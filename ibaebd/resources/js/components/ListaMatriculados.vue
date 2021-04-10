<template>
    <div class="container">
        <div class="card">
            <div class="card-header lead d-flex justify-content-between">
                <span class="h4">Lista de Matriculados</span>
				<div class="input-group-append">
                    <matricula-page :edicao="matricula" @retornoMatriculas="attMatriculas"></matricula-page>

					<button class="btn btn-primary" @click="abrirModalMatricula()" type="button" data-toggle="tooltip" data-placement="bottom" title="Matricular">
						<i class="fas fa-plus fa-lg"></i>
					</button>
                    <button class="btn btn-outline-secondary" @click="getMatriculas" style="margin-left:7px;" type="button" data-toggle="tooltip" data-placement="bottom" title="Recarregar Matriculados">
                        <i class="fas fa-redo fa-lg"></i>
                    </button>
				</div>
            </div>
            <div class="card-body">
				<div v-if="isRequesting==true" class="d-flex justify-content-center">
					<div class="spinner-border m-5" role="status">
						<span class="sr-only">Carregando...</span>
					</div>
				</div>
				<div v-else-if="matriculados.length>0" class="table-responsive row">
					<div class="left col col-8 col-md-12">
						<table class="table table-hover table-sm table-responsive-md">
							<thead class="thead-light">
								<tr>
									<th scope="col col-1">Matrícula</th>
									<th scope="col">Nome</th>
                                    <th scope="col">Classe</th>
									<th scope="col">Ações</th>
								</tr>
							</thead>
							<tbody v-for="(mat, idx) in matriculados" :key="idx">
								<tr>
									<td>{{mat.id}}</td>
									<td>{{mat.nome + ' ' + mat.sobrenome}}</td>
                                    <td>{{mat.classe=='batismo'?'Batismo':'erro'}}</td>
									<td class="content-right">
										<div class="input-group-append justify-content-right" id="button-addon4">
											<button @click="editarMatricula(mat)" type="button" style="margin-right:4px;" class="btn btn-outline-secondary btn-sm" data-toggle="tooltip" data-placement="bottom" title="Editar">
												<i class="fas fa-edit fa-fw"></i>
											</button>
											<button @click="deletar(mat.id)" :disabled="isRequesting==true" type="button" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-placement="bottom" title="Deletar">
												<i class="fas fa-trash-alt fa-fw"></i>
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
    name:'ListaMatriculados',

    data() {
        return {
            isRequesting:false, erros:{}, matriculados:[], matricula:null,
        }
    },

    methods:{
        getMatriculas(){
            this.isRequesting=true;
            axios.get('/getMatriculas')
                .then(res=>{ this.isRequesting=false; this.matriculados=res.data; })
                .catch(err=>{ this.isRequesting=false; console.error(err); })
        },

        deletar(id){
            if(confirm('Deseja deletar esta Matrícula?')){
                this.isRequesting=true;
                axios.delete('/deletar/'+id)
                    .then(res=>{ this.isRequesting=false; this.matriculados=res.data; })
                    .catch(err=>{ this.isRequesting=false; console.error(err); })
            }
        },

        editarMatricula(item){ this.matricula = {...item};  $('#modalMatricula').modal('show'); },

        attMatriculas(val){ this.matriculados = val; },

        abrirModalMatricula(){
            this.erros=[];
            this.matricula={
                nome:'', sobrenome:'', cpf:'', rg:'', orgao_emissor:'', uf:'', nascimento:'',
                email:'', isEvangelico:0, isMembro:0, classe:'batismo', sexo:0, conversao:'',
                telefones:{tel1:'',tel2:null,}, endereco:{logradouro:'', bairro:'', num:'', cep:'', complemento:'', cidade:'',},
            };
            $('#modalMatricula').modal('show');
        },

    },

    mounted() {
        this.getMatriculas();
    },

}
</script>