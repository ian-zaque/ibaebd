<template>
    <div class="container">
        <div class="card">
            <div class="card-header lead d-flex justify-content-between">
                <span class="h4">Lista de Matriculados</span>
				<div class="input-group-append">
                    <matricula-page :edicao="matricula" @retornoMatriculas="attMatriculas"></matricula-page>

					<button @click="abrirModalMatricula()" class="btn btn-primary" type="button" data-toggle="tooltip" data-placement="bottom" title="Matricular">
						<i class="fas fa-plus fa-lg"></i>
					</button>
                    <button @click="getMatriculas" class="btn btn-outline-secondary" style="margin-left:7px;" type="button" data-toggle="tooltip" data-placement="bottom" title="Recarregar Matriculados">
                        <i class="fas fa-redo fa-lg"></i>
                    </button>
                     <button @click="baixarPlanilha" class="btn btn-outline-secondary" style="margin-left:7px;" type="button" data-toggle="tooltip" data-placement="bottom" title="Baixar Planilha de Matriculados">
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
                                            <button @click="baixarFicha(mat)" type="button" style="margin-right:4px;" class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="bottom" :title="'Baixar Ficha de '+mat.nome">
                                                <i class="fas fa-id-badge fa-lg"></i>
                                            </button>
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
import print from 'print-js'
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
                .then(res=>{ this.isRequesting=false; this.matriculados=res.data; this.erros=null; })
                .catch(err=>{ this.isRequesting=false; console.error(err); })
        },

        deletar(id){
            if(confirm('Deseja deletar esta Matrícula?')){
                this.isRequesting=true;
                axios.delete('/deletar/'+id)
                    .then(res=>{ this.isRequesting=false; this.matriculados=res.data; this.erros=null; })
                    .catch(err=>{ this.isRequesting=false; console.error(err); this.erros=null; })
            }
        },

        baixarFicha(item){
            this.matricula = {...item}; $('#modalMatricula').modal('show'); 
            printJS({
                printable:'corpo_modal', 
                type:'html',
                header:'IGREJA BATISTA ALVORADA - EBDIscipuladora'
            }); 
            $('#modalMatricula').modal('hide');
        },

        editarMatricula(item){ this.erros=null; this.matricula = {...item};  $('#modalMatricula').modal('show'); },

        attMatriculas(val){ this.matriculados = val; },

        abrirModalMatricula(){
            this.erros=null; delete this.matricula.id;
            this.matricula={
                nome:'', sobrenome:'', cpf:'', rg:'', orgao_emissor:'', uf:'', nascimento:'',
                email:'', isEvangelico:false, isMembro:false, classe:'batismo', sexo:false, conversao:'',
                telefones:{tel1:'',tel2:null,}, endereco:{logradouro:'', bairro:'', num:'', cep:'', complemento:'', cidade:'',},
            };
            $('#modalMatricula').modal('show');
        },

        baixarPlanilha(){
            var mat = this.matriculados.map(function(val){
                return [
                    ''+val.id, 
                    val.nome+' '+val.sobrenome, 
                    val.sexo==false?'Masculino':'Feminino', 
                    val.cpf, 
                    val.rg, 
                    new Date(val.nascimento).toLocaleDateString(),
                    val.email==null||val.email==''?'-':val.email,
                    ''+val.telefones.tel1,
                    val.telefones.tel2==''||val.telefones.tel2==null?'-':''+val.telefones.tel2,
                    val.conversao==null||val.conversao==''?'-': new Date(val.conversao).toLocaleDateString().replace('/','-'),
                    val.isEvangelico==false?'Nao':'Sim',
                    val.isMembro==false?'Nao':'Sim',
                    val.endereco.logradouro +', '+ val.endereco.num+', '+ val.endereco.bairro,
                    val.endereco.cidade,
                    val.endereco.cep==''||val.endereco.cep==null?'':val.endereco.cep,
                    val.endereco.complemento==''||val.endereco.complemento==null?'':val.endereco.complemento
                ];
            });

            mat.unshift([
                'ID','Nome','Sexo','CPF','RG','Data de Nascimento','Email','Telefone 1','Telefone 2',
                'Data de Conversao', 'Evangelico?', 'Membro?', 'Endereco', 'Cidade', 'CEP', 'Complemento',
            ]);
            let csvContent = "data:text/csv;charset=utf-8,"  + mat.map(e => e.join(";")).join("\n");
            var encodedUri = encodeURI(csvContent);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "Planilha_Matricula_IBA_EBD.csv");
            document.body.appendChild(link);

            link.click();
        },

    },

    mounted() {
        this.getMatriculas();
    },

}
</script>