<template>
    <div>
        <div class="card">
            <div class="card-header lead d-flex justify-content-between">
                <span class="h4">Inscritos na Manhã Divertida</span>
				<div class="input-group-append">
                    <matricula-manhaDivertida :edicao="matricula" :isEditingManha="isEditingManha" 
                        @retornoInscricoesManhaDivertida="attMatriculas">
                    </matricula-manhaDivertida>

					<button @click="abrirModalMatricula()" class="btn btn-primary" type="button" data-toggle="tooltip" data-placement="bottom" title="Matricular">
						<i class="fas fa-plus fa-lg"></i>
					</button>
                    <button @click="getMatriculas" class="btn btn-outline-secondary" style="margin-left:7px;" type="button" data-toggle="tooltip" data-placement="bottom" title="Recarregar Matriculados">
                        <i class="fas fa-redo fa-lg"></i>
                    </button>
                     <button v-if="matriculados.length > 0" @click="baixarPlanilha" class="btn btn-outline-secondary" style="margin-left:7px;" type="button" data-toggle="tooltip" data-placement="bottom" title="Baixar Planilha de Matriculados">
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
									<th scope="col col-1">Inscrição</th>
									<th scope="col">Nome</th>
									<th scope="col">Idade</th>
									<th scope="col">Ações</th>
								</tr>
							</thead>
							<tbody v-for="(mat, idx) in matriculados" :key="idx">
								<tr>
									<td>{{mat.id}}</td>
                                    <td>{{mat.nome + ' ' + mat.sobrenome}}</td>
                                    <td>{{mat.idade + ' anos'}}</td>
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
    name:'ListaManhaDivertida',

    data() {
        return {
            isRequesting:false, erros:{}, matriculados:[], isEditingManha:null,
            matricula:{
                nome:'', sobrenome:'', idade:'', nome_responsavel:'', nome_pai:'', nome_mae:'', banho_mangueira:true, contato:'',
            },
        }
    },

    methods:{
        getMatriculas(){
            this.isRequesting=true;
            axios.get('/inscricaoManhaDivertida')
                .then(res=>{ this.isRequesting=false; this.matriculados=res.data; this.erros={}; })
                .catch(err=>{ this.isRequesting=false; console.error(err); })
        },

        deletar(id){
            if(confirm('Deseja deletar esta Inscrição?')){
                this.erros={}; this.isRequesting=true;
                axios.delete('/inscricaoManhaDivertida/deletar/'+id)
                    .then(res=>{ this.isRequesting=false; this.matriculados=res.data; this.erros={}; })
                    .catch(err=>{ this.isRequesting=false; console.error(err); this.erros={}; })
            }
        },

        editarMatricula(item){ 
            this.isEditingManha=true; this.erros={}; this.matricula = Object.assign({},item); 
            $('#modalManhaDivertida').modal('show');
        },

        attMatriculas(val){ this.matriculados = val; },

        abrirModalMatricula(){
            this.erros={}; this.isEditingManha=false;
            if(this.matricula!=null && this.matricula.hasOwnProperty('id')){ delete this.matricula.id; }
            this.matricula={
               nome:'', sobrenome:'', idade:'', nome_responsavel:'', nome_pai:'', nome_mae:'', banho_mangueira:true, contato:'',
            };
            $('#modalManhaDivertida').modal('show');
        },

        baixarPlanilha(){
            var mat = this.matriculados.map(function(val){
                return [
                    ''+val.id, 
                    val.nome+' '+val.sobrenome,
                    val.idade,
                    val.banho_mangueira ==false?'Nao':'Sim',
                    val.idade <= 5? val.nome_responsavel :'-',
                    val.contato,
                    val.nome_pai,
                    val.nome_mae,    
                ];
            });

            mat.unshift([
               'ID', 'Nome', 'Idade', 'Banho de Mangueira?', 'Nome do Responsavel', 'Contato', 'Nome do Pai', 'Nome da Mae',
            ]);
            let csvContent = "data:text/csv;charset=utf-8,"  + mat.map(e => e.join(";")).join("\n");
            var encodedUri = encodeURI(csvContent);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "Planilha_Manha_Divertida.csv");
            document.body.appendChild(link);

            link.click();
        },

    },

    mounted() {
        this.getMatriculas();
    },

}
</script>