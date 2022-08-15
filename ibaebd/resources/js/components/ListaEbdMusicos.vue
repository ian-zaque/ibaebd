<template>
    <div>
        <div class="card">
            <div class="card-header lead d-flex justify-content-between">
                <span class="h4">Lista EBD Músicos - {{ matriculados.length > 0 ? matriculados.length + ' músico(s)' : '' }}</span>
				<div class="input-group-append">
                    <matricula-ebdMusicos :edicao="matricula" :isEditingEbdMusicos="isEditingEbdMusicos" @retornoInscricoesEbdMusicos="attInscricoes">
                    </matricula-ebdMusicos>

					<button @click="abrirModalEbdMusicos()" class="btn btn-primary" type="button" data-toggle="tooltip" data-placement="bottom" title="Inscrever">
						<i class="fas fa-plus fa-lg"></i>
					</button>
                    <button @click="getMatriculas" class="btn btn-outline-secondary" style="margin-left:7px;" type="button" data-toggle="tooltip" data-placement="bottom" title="Recarregar Inscritos">
                        <i class="fas fa-redo fa-lg"></i>
                    </button>
                     <button v-if="matriculados.length > 0" @click="baixarPlanilha" class="btn btn-outline-secondary" style="margin-left:7px;" type="button" data-toggle="tooltip" data-placement="bottom" title="Baixar Planilha de Inscritos">
                        <i class="fas fa-table fa-lg"></i>
                    </button>
				</div>
            </div>
            <div class="card-body">
				<div v-if="isRequesting==true" class="d-flex justify-content-center">
					<div class="spinner-border m-5" role="status">
						<span class="sr-only">Carregando...</span>
					</div>
				</div>
				<div v-else-if="matriculados.length > 0">
					<div class="left col col-12 col-md-12">
						<table class="table table-hover table-sm table-responsive-md">
							<thead class="thead-light">
								<tr>
									<th scope="col col-1">ID</th>
									<th scope="col">Nome</th>
									<th scope="col">Ações</th>
								</tr>
							</thead>
							<tbody v-for="(mat, idx) in matriculados" :key="idx">
								<tr>
									<td>{{mat.id}}</td>
									<td>{{mat.nome + ' ' + mat.sobrenome}}</td>
									<td class="content-right">
										<div class="input-group-append justify-content-right" id="button-addon4">
											<button @click="editarMatricula(mat)" type="button" style="margin-right:4px;" class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="bottom" title="Editar">
												<i class="fas fa-edit fa-lg"></i>
											</button>
											<button @click="deletar(mat.id)" :disabled="isRequesting==true" type="button" class="btn btn-outline-danger" data-toggle="tooltip" data-placement="bottom" title="Deletar">
												<i class="fas fa-trash-alt fa-lg"></i>
											</button>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div v-else> <empty-space></empty-space> </div>
			</div>
		</div>
    </div>
</template>

<script>
export default {
    name:'ListaEbdMusicos',

    data() {
        return {
            isRequesting:false, erros:{}, matriculados:[], matricula:null, isEditingEbdMusicos:null,
        }
    },

    methods:{
        getMatriculas(){
            this.isRequesting=true;
            axios.get('/ebdMusicos')
                .then(res=>{ this.isRequesting=false; this.matriculados=res.data; this.erros={}; })
                .catch(err=>{ this.isRequesting=false; console.error(err); })
        },

        deletar(id){
            if(confirm('Deseja deletar esta Inscrição?')){
                this.erros={}; this.isRequesting=true;
                axios.delete('/ebdMusicos/deletar/'+id)
                    .then(res=>{ this.isRequesting=false; this.matriculados=res.data; this.erros={}; })
                    .catch(err=>{ this.isRequesting=false; console.error(err); this.erros={}; })
            }
        },

        editarMatricula(item){
            this.isEditingEbdMusicos=true; this.erros={};
            this.matricula = Object.assign({},item); $('#modalEbdMusicos').modal('show'); 
        },

        attInscricoes(val){ this.matriculados = val; },

        abrirModalEbdMusicos(){
            this.erros={}; this.isEditingEbdMusicos=false;
            if(this.matricula!=null && this.matricula.hasOwnProperty('id')){ delete this.matricula.id; }
            this.matricula={
                nome: '', sobrenome: '', nascimento:'', email:'', telefone:'', grupo_mma:[], tempo_mma:'', instrumento:[],
                naipe_vocal:'', pgm:'', tempo_pgm:'', preferencia_horario:'', versiculo:'',
            };
            $('#modalEbdMusicos').modal('show');
        },

        baixarPlanilha(){
            function getPreferencia(value){
                if(value == '1'){ return 'Terças às 19h30' }
                else if(value == '2'){ return 'Sábados às 15h' }
                else if(value == '3'){ return 'Domingo às 9h' }
                else { return '-' }
            };

            var mat = this.matriculados.map(function(val){


                return [
                    ''+val.id, 
                    val.nome+' '+val.sobrenome, 
                    new Date(val.nascimento).toLocaleDateString(),
                    val.email,
                    val.telefone,
                    val.grupo_mma,
                    val.tempo_mma + ' anos',
                    val.instrumento == ''|| val.instrumento==null ? '-' : val.instrumento,
                    val.naipe_vocal == ''|| val.naipe_vocal==null ? '-' : val.naipe_vocal,
                    val.pgm,
                    val.tempo_pgm + ' anos',
                    getPreferencia(val.preferencia_horario),
                    val.versiculo
                ];
            });

            mat.unshift([
                'ID','Nome', 'Data de Nascimento','Email', 'Telefone', 
                'Grupo de Louvor', 'Tempo no(s) Grupo(s)', 'Instrumento(s)',
                'Naipe Vocal', 'PGM', 'Tempo no PGM', 
                'Preferência de Horário', 'Versículo',
            ]);
            var universalBOM = "\uFEFF";
            let csvContent = "data:text/csv;charset=utf-8,"  + universalBOM+ mat.map(e => e.join(";")).join("\n");
            var encodedUri = encodeURI(csvContent);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "Planilha EBD Musicos.csv");
            document.body.appendChild(link);

            link.click();
        },

    },

    mounted() {
        this.getMatriculas();
    },

}
</script>