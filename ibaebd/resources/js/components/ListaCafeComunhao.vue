<template>
    <div>
        <div class="card">
            <div class="card-header lead d-flex justify-content-between">
                <span class="h4">Lista do Café & Comunhão {{ matriculados.length > 0 ? '- ' + matriculados.length +  ' doações' : '' }}</span>
				<div class="input-group-append">
                    <matricula-cafeComunhao :isEditingCafeComunhao="isEditing" :edicao="matricula" @retornoCadastrosCafeComunhao="attMatriculas">
                    </matricula-cafeComunhao>

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
						<table class="table table-hover table-responsive-md">
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
    name:'ListaCafeComunhao',

    data() {
        return {
            isRequesting:false, erros:{}, matriculados:[], matricula:null, isEditing:null,
            opcoesDoacao:[
                'Bolo', 'Queijo', 'Presunto', 'Banana da Terra', 'Suco', 'Frutas', 'Pão de Queijo',
            ],
        }
    },

    methods:{
        getMatriculas(){
            this.isRequesting=true;
            axios.get('/cafeComunhao')
                .then(res=>{ this.isRequesting=false; this.matriculados=res.data; this.erros={}; })
                .catch(err=>{ this.isRequesting=false; console.error(err); })
        },

        deletar(id){
            if(confirm('Deseja deletar esta Matrícula?')){
                this.erros={}; this.isRequesting=true;
                axios.delete('/cafeComunhao/deletar/'+id)
                    .then(res=>{ this.isRequesting=false; this.matriculados=res.data; this.erros={}; })
                    .catch(err=>{ this.isRequesting=false; console.error(err); this.erros={}; })
            }
        },

        editarMatricula(item){ this.isEditing=true; this.erros={}; this.matricula = Object.assign({},item);  $('#modalCafeComunhao').modal('show'); },

        attMatriculas(val){ this.matriculados = val; this.isRequesting=false; },

        abrirModalMatricula(){
            this.erros={}; this.isEditing=false;
            if(this.matricula!=null && this.matricula.hasOwnProperty('id')){ delete this.matricula.id; }
            this.matricula={
                nome: '', sobrenome: '', contato:'', qtd_participantes: null, payment: null, valor:null, doacoes:new Array(7).fill(false),
            };
            $('#modalCafeComunhao').modal('show');
        },

        baixarPlanilha(){
            var vm = this
            var mat = this.matriculados.map(function(val){
                return [
                    ''+val.id, 
                    val.nome+' '+val.sobrenome, 
                    val.contato,
                    val.qtd_participantes,
                    val.payment == false ? 'Espécie' : 'Pix',
                    val.valor,
                    vm.opcoesDoacao.filter(function(v,idx){ if(val.doacoes[idx] == true){ return v } }).filter(function(item,i){ return item != undefined })
                ];
            });

            mat.unshift([
                'ID','Nome','Contato', 'Qtd. de Participantes','Forma de Doação','Valor de Doação','Opções de Doações',
            ]);

            var universalBOM = "\uFEFF";
            let csvContent = "data:text/csv;charset=utf-8,"  + universalBOM+ mat.map(e => e.join(";")).join("\n");
            var encodedUri = encodeURI(csvContent);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "Planilha_Cafe_Comunhao.xls");
            document.body.appendChild(link);

            link.click();
        },

    },

    mounted() {
        this.getMatriculas();
    },

}
</script>