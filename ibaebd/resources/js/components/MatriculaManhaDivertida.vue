<template>
    <div>
		<div class="modal w3-animate-opacity" data-backdrop="static" id="modalManhaDivertida" tabindex="-1" role="dialog" aria-labelledby="ModalMatriculaLabel" aria-hidden="true">
		  	<div class="modal-dialog modal-lg" role="document">
		    	<div class="modal-content">
					<div class="modal-header">
                        <div class="d-flex justify-content-start">
                            <h5 class="modal-title" id="ModalMatriculaLabel">
                                    {{ (editando==null||editando==false)? 'Inscrição Manhã Divertida':
                                        'Editando Inscrição de '+ edicao.nome }}
                            </h5>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button v-if="(editando!=null&&editando!=false)" @click="imprimirFicha" type="button" style="margin-right:4px;" class="btn btn-outline-secondary" 
                                data-toggle="tooltip" data-placement="bottom" title="Imprimir Ficha">
                                    <i class="fas fa-print fa-lg"></i>
                            </button>
                            <button @click="fechar" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>                            
                        </div>
					</div>
					<div  class="modal-body">
                    <form action="#" id="corpo_modal">
						<div class="row">
							<div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Nome da Criança*</label>
									<input class="form-control form-control-sm" placeholder="Insira o Nome da criança" type="text" v-model="matricula.nome" required>
                                    <small v-if="erros.nome" class="text-danger" style="font-size:10px" :hidden="(!erros.nome)">{{erros.nome.toString()}}</small>
                                </div>
							</div>
							<div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Sobrenome da Criança*</label>
									<input class="form-control form-control-sm" placeholder="Insira o Sobrenome da criança" type="text" v-model="matricula.sobrenome" required>
                                    <small v-if="erros.sobrenome" class="text-danger" style="font-size:10px" :hidden="(!erros.sobrenome)">{{erros.sobrenome.toString()}}</small>
                                </div>
							</div>
						</div>
                        <div class="row">
							<div class="col col-5 col-md-5">
								<div class="form-group">
									<label>Idade da Criança*</label>
									<input class="form-control form-control-sm" placeholder="Insira a Idade da criança" :min="3" :max="12" type="number" v-model="matricula.idade" required>
                                    <small v-if="erros.idade" class="text-danger" style="font-size:10px" :hidden="(!erros.idade)">{{erros.idade.toString()}}</small>
                                </div>
							</div>
							<div v-if="matricula.idade <= 5" class="col col-7 col-md-7">
								<div class="form-group">
									<label>Nome do Responsável**</label>
									<input class="form-control form-control-sm" placeholder="Responsável pela criança" type="text" v-model="matricula.nome_responsavel">
                                    <small>**Para crianças entre 3 e 5 anos de idade</small>
                                    <small v-if="erros.nome_responsavel" class="text-danger" style="font-size:10px" :hidden="(!erros.nome_responsavel)">{{erros.nome_responsavel.toString()}}</small>
                                </div>
							</div>
						</div>

                        <div class="row">
                            <div class="col col-12 col-md-12">
								<div class="form-group">
									<label>Pai da Criança</label>
									<input class="form-control form-control-sm" placeholder="Insira o nome do pai da criança" type="text" v-model="matricula.nome_pai">
                                    <small v-if="erros.nome_pai" class="text-danger" style="font-size:10px" :hidden="(!erros.nome_pai)">{{erros.nome_pai.toString()}}</small>
                                </div>
							</div>
                        </div>

                        <div class="row">
                            <div class="col col-12 col-md-12">
								<div class="form-group">
									<label>Mãe da Criança</label>
									<input class="form-control form-control-sm" placeholder="Insira o nome da mãe da criança" type="text" v-model="matricula.nome_mae">
                                    <small v-if="erros.nome_mae" class="text-danger" style="font-size:10px" :hidden="(!erros.nome_mae)">{{erros.nome_mae.toString()}}</small>
                                </div>
							</div>
                        </div>

                        <div class="row">
                            <div class="col col-6 col-md-6">
                                <label>A criança pode tomar banho de mangueira? *</label>
								<div class="form-group">
									<div class="form-check form-check-inline">
                                        <input v-model="matricula.banho_mangueira" class="form-check-input" type="radio" id="radio_btn_s" :value="true">
                                        <label class="form-check-label" for="radio_btn_s">Sim</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input v-model="matricula.banho_mangueira" class="form-check-input" type="radio"  id="radio_btn_n" :value="false">
                                        <label class="form-check-label" for="radio_btn_n">Não</label>
                                    </div>
                                    <small v-if="erros.banho_mangueira" class="text-danger" style="font-size:10px" :hidden="(!erros.banho_mangueira)">{{erros.banho_mangueira.toString()}}</small>
								</div>
							</div>

                            <div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Contato</label>
									<input class="form-control form-control-sm" v-model="matricula.contato" v-mask="['(##) ####-####', '(##) #####-####']" 
                                        placeholder="Insira seu Telefone" type="tel" required>
                                    <small v-if="erros.contato" class="text-danger" style="font-size:10px" :hidden="(!erros.contato)">
                                        {{ erros.contato.toString() }}
                                    </small>
                                </div>
							</div>
                        </div>

                        <div class="row">
                            <div class="col-12 text-left">
                                <p class="bd-lead">Trazer muda de roupa e toalha!</p>
                            </div>
                        </div>

                    </form>
                    </div>

                    <div class="row">
                        <div class="col col-12 col-md-12">
                            <div style="margin-right:13px;">
                                <p class="small text-danger">*Obrigatório!</p>
                            </div>
                        </div>
                    </div>

					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" @click="fechar" :disabled="isRequesting==true" data-dismiss="modal">Fechar</button> 
						<button type="button" class="btn btn-primary" @click="cadastrar" :disabled="isRequesting==true">
                            {{ (editando==null||editando==false) ? 'Inscrever':'Atualizar'}}
                        </button>
					</div>
		    	</div>
		  	</div>
		</div>
    </div>
</template>
<script>
import {TheMask} from 'vue-the-mask'
import print from 'print-js'

export default {
    name:'MatriculaManhaDivertidaPage',

    components:{ TheMask },
    directives:{ print },

    props:{
        edicao:{ type:Object, default:null },
        isEditingManha:{ type:Boolean, default:null }
    },

    data() {
        return {
            isRequesting:false, sucesso:false, erros:{}, isPrinting:false,
            matricula: {
                nome:'', sobrenome:'', idade:'', nome_responsavel:'', nome_pai:'', nome_mae:'', banho_mangueira:true, contato:'',
            }
        }
    },

    watch:{
        edicao(val){
            if(val!=null && val!={}){
                this.matricula=Object.assign({},val);
            }
        },
    },

    computed:{
        editando(){ return this.isEditingManha; },
        matriculaClone(){ 
            this.matricula=Object.assign({},this.edicao); return 'foi';
        }
    },

    methods: {
        imprimirFicha(){
            this.isPrinting = true;
            var arrayCss=[
                "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css",
            ]
            printJS({
                printable:'corpo_modal', 
                type:'html',
                header:'IBA-Inscrição de ' + this.edicao.nome +' '+ this.edicao.sobrenome,
                documentTitle:'Inscrição Manhã Divertida de '+ this.edicao.nome +' '+ this.edicao.sobrenome,
                css:arrayCss,
                modalMessage:'Carregando...',
                onPrintDialogClose: ()=>{ this.isPrinting=false; },
                onError: (err) =>{ 
                    alert("Houve um erro ao imprimir esta ficha!!! Tente Novamente"); this.isPrinting=false;
                    $('#modalManhaDivertida').modal('show');
                },
            });
            this.isPrinting=false;
        },

        fechar(){
            this.matricula={
                nome:'', sobrenome:'', idade:'', nome_responsavel:'', nome_pai:'', nome_mae:'', banho_mangueira:true, contato:'',
            };
            this.erros={}; $('#modalManhaDivertida').modal('hide');
        },

        cadastrar(){
            if(confirm('Deseja confirmar a inscrição?')){
                this.isRequesting=true; this.erros={};
                axios.post('/inscricaoManhaDivertida/atualizar',this.matricula)
                    .then(res=>{
                        this.isRequesting=false; this.sucesso=true; this.erros={};
                        alert('Inscrição efetuada com sucesso!!!'); $('#modalManhaDivertida').modal('hide');

                        if(this.edicao!=null){ 
                            this.$emit('retornoInscricoesManhaDivertida', res.data); 
                        }
                    })
                    .catch(err=>{
                        this.isRequesting=false; this.erros=Object.values(err);
                        this.erros = this.erros[2].data;
                    })
            }
        },

    },
}
</script>