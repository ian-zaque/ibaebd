<template>
    <div>
        <div class="card">
            <div class="card-header lead d-flex justify-content-between">
                <span class="h4">Lista Só Pra Casais - {{ matriculados.length > 0 ? matriculados.length + ' casais matriculados' : '' }}</span>
				<div class="input-group-append">
                    <matricula-casais :edicao="matricula" :isEditingCasais="isEditingCasais" @retornoInscricoesSoPraCasais="attInscricoes">
                    </matricula-casais>

					<button @click="abrirModalMatricula()" class="btn btn-primary" type="button" data-toggle="tooltip" data-placement="bottom" title="Inscrever">
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
									<th scope="col">Esposo</th>
                                    <th scope="col">Esposa</th>
									<th scope="col">Ações</th>
								</tr>
							</thead>
							<tbody v-for="(mat, idx) in matriculados" :key="idx">
								<tr>
									<td>{{mat.id}}</td>
									<td>{{mat.esposo.nome + ' ' + mat.esposo.sobrenome}}</td>
									<td>{{mat.esposa.nome + ' ' + mat.esposa.sobrenome}}</td>
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
    name:'ListaSoPraCasais',

    data() {
        return {
            isRequesting:false, erros:{}, matriculados:[], matricula:null, isEditingCasais:null,
        }
    },

    methods:{
        getMatriculas(){
            this.isRequesting=true;
            axios.get('/casais')
                .then(res=>{ this.isRequesting=false; this.matriculados=res.data; this.erros={}; })
                .catch(err=>{ this.isRequesting=false; console.error(err); })
        },

        deletar(id){
            if(confirm('Deseja deletar esta Inscrição?')){
                this.erros={}; this.isRequesting=true;
                axios.delete('/casais/deletar/'+id)
                    .then(res=>{ this.isRequesting=false; this.matriculados=res.data; this.erros={}; })
                    .catch(err=>{ this.isRequesting=false; console.error(err); this.erros={}; })
            }
        },

        editarMatricula(item){
            this.isEditingCasais=true; this.erros={};
            this.matricula = Object.assign({},item); $('#modalSoPraCasais').modal('show'); 
        },

        attInscricoes(val){ this.matriculados = val; },

        abrirModalMatricula(){
            this.erros={}; this.isEditingCasais=false;
            if(this.matricula!=null && this.matricula.hasOwnProperty('id')){ delete this.matricula.id; }
            this.matricula={
                esposo:{
                    nome:'', sobrenome:'', igreja:'', telefone:'', nascimento:'', membresia :'',
                },
                esposa:{
                    nome:'', sobrenome:'', igreja:'', telefone:'', nascimento:'', membresia :'',
                },
                logradouro:'', bairro:'', num:'', cep:'', complemento:'', cidade:'',
            };
            $('#modalSoPraCasais').modal('show');
        },

        baixarPlanilha(){
            var mat = this.matriculados.map(function(val){
                return [
                    ''+val.esposo.id, 
                    val.esposo.nome+' '+val.esposo.sobrenome, 
                    val.esposo.igreja,
                    val.esposo.telefone,
                    new Date(val.esposo.nascimento).toLocaleDateString(),
                    val.esposo.membresia == 'm' ? 'Membro': val.esposo.membresia == 'c' ?'Congregado' : 'Sem Igreja',

                    ''+val.esposa.id, 
                    val.esposa.nome+' '+val.esposa.sobrenome, 
                    val.esposa.igreja,
                    val.esposa.telefone,
                    new Date(val.esposa.nascimento).toLocaleDateString(),
                    val.esposa.membresia == 'm' ? 'Membro': val.esposa.membresia == 'c' ?'Congregado' : 'Sem Igreja',

                    val.casamento,
                    val.qntd_filhos,

                    val.logradouro +', '+ val.num+', '+ val.bairro,
                    val.cidade,
                    val.cep==''||val.cep==null?'':val.cep,
                    val.complemento==''||val.complemento==null?'':val.complemento
                ];
            });

            mat.unshift([
                'ID Esposo','Nome Esposo','Igreja Esposo', 'Telefone Esposo', 'Nascimento Esposo', 'Membresia Esposo',
                'ID Esposa','Nome Esposa','Igreja Esposa', 'Telefone Esposa', 'Nascimento Esposa', 'Membresia Esposa',
                'Data de Casamento', 'Qtd. FIlhos', 
                'Endereco', 'Cidade', 'CEP', 'Complemento',
            ]);
            var universalBOM = "\uFEFF";
            let csvContent = "data:text/csv;charset=utf-8,"  + universalBOM+ mat.map(e => e.join(";")).join("\n");
            var encodedUri = encodeURI(csvContent);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "Planilha_So_Pra_Casais_IBA_EBD.csv");
            document.body.appendChild(link);

            link.click();
        },

    },

    mounted() {
        this.getMatriculas();
    },

}
</script>