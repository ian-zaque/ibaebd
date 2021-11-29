<template>
    <div>
		<div class="modal w3-animate-opacity" data-backdrop="static" id="modalCafeComunhao" tabindex="-1" role="dialog" aria-labelledby="ModalMatriculaLabel" aria-hidden="true">
		  	<div class="modal-dialog modal-lg" role="document">
		    	<div class="modal-content">
					<div class="modal-header">
                        <div class="d-flex justify-content-start">
                            <h5 class="modal-title" id="ModalMatriculaLabel">
                                    {{ (editando==null||editando==false)? 'Cadastros Café & Comunhão':
                                        'Editando Cadastro de '+ edicao.nome }}
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
                    <div class="card-body text-center">
                        <h5 class="card-title">Escolha o(s) item(s) de sua preferência e faça sua doação!</h5>
                        <p class="card-text">Pix do valor - <b> 157.967.105-59 </b> (Edvaldo Barbosa Costa) </p>
                        <p class="card-text">Em Espécie - 2ª à 6ª na Secretaria da IBA ou domingo no estacionamento</p>
                    </div>

                    <form action="#" id="corpo_modal">
						<div class="row">
							<div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Nome*</label>
									<input class="form-control form-control-sm" placeholder="Insira o Nome" type="text" v-model="matricula.nome" required>
                                    <small v-if="erros.nome" class="text-danger" style="font-size:10px" :hidden="(!erros.nome)">{{erros.nome.toString()}}</small>
                                </div>
							</div>
							<div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Sobrenome*</label>
									<input class="form-control form-control-sm" placeholder="Insira o Sobrenome" type="text" v-model="matricula.sobrenome" required>
                                    <small v-if="erros.sobrenome" class="text-danger" style="font-size:10px" :hidden="(!erros.sobrenome)">{{erros.sobrenome.toString()}}</small>
                                </div>
							</div>
						</div>
                        <div class="row">
							<div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Contato *</label>
									<input class="form-control form-control-sm" v-model="matricula.contato" v-mask="['(##) ####-####', '(##) #####-####']" 
                                        placeholder="Insira seu Telefone" type="tel" required>
                                    <small v-if="erros.contato" class="text-danger" style="font-size:10px" :hidden="(!erros.contato)">
                                        {{ erros.contato.toString() }}
                                    </small>
                                </div>
							</div>
                            <div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Participantes no Café além de você *</label>
									<input class="form-control form-control-sm" placeholder="Quantidade de participantes" :min="0" type="number" v-model="matricula.qtd_participantes" required>
                                    <small v-if="erros.qtd_participantes" class="text-danger" style="font-size:10px" :hidden="(!erros.qtd_participantes)">{{erros.qtd_participantes.toString()}}</small>
                                </div>
							</div>
						</div>

                        <div class="row">
                            <div class="col col-6 col-md-6">
                                <label>Forma de doação *</label>
								<div class="form-group">
									<div class="form-check form-check-inline">
                                        <input v-model="matricula.payment" class="form-check-input" type="radio" id="radio_btn_s" :value="true">
                                        <label class="form-check-label" for="radio_btn_s">Pix</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input v-model="matricula.payment" class="form-check-input" type="radio"  id="radio_btn_n" :value="false">
                                        <label class="form-check-label" for="radio_btn_n">Espécie</label>
                                    </div>
                                    <small v-if="erros.payment" class="text-danger" style="font-size:10px" :hidden="(!erros.payment)">{{erros.payment.toString()}}</small>
								</div>
							</div>

                            <div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Valor da Doação *</label>
									<input class="form-control form-control-sm" v-model="matricula.valor" v-mask="['##.##', '###.##']" 
                                        placeholder="Insira o valor da doação (R$)" type="tel" required>
                                    <small v-if="erros.valor" class="text-danger" style="font-size:10px" :hidden="(!erros.valor)">
                                        {{ erros.valor.toString() }}
                                    </small>
                                </div>
							</div>
                        </div>

                        <div class="row">
                            <div class="col col-12 col-md-12">
                                <div class="form-group">
                                    <label>Opções de Doação</label>
                                    <div v-for="(option, idx) in opcoesDoacao" :key="idx" class="form-check">
                                        <input v-model="matricula.doacoes[idx]" class="form-check-input" type="checkbox" :id="'defaultCheck'+idx">
                                        <label class="form-check-label" :for="'defaultCheck'+idx">
                                            {{ option.name + ' - ' + 'R$' + option.value }}
                                        </label>
                                    </div>
                                </div>
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
                            {{ (editando==null||editando==false) ? 'Cadastrar':'Atualizar'}}
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
    name:'MatriculaCafeComunhaoPage',

    components:{ TheMask },
    directives:{ print },

    props:{
        edicao:{ type:Object, default:null },
        isEditingCafeComunhao:{ type:Boolean, default:null }
    },

    data() {
        return {
            isRequesting:false, sucesso:false, erros:{}, isPrinting:false,
            opcoesDoacao:[
                {name: 'Bolo', value: '15,00'}, {name: 'Queijo', value: '10,00'}, {name: 'Presunto', value: '10,00'},
                {name: 'Banana da Terra', value: '10,00'}, {name: 'Suco', value: '10,00'}, {name: 'Frutas', value: '8,00'},
                {name: 'Pão de Queijo', value: '8,00'},
            ],
            matricula: {
                nome: '', sobrenome: '', contato:'', qtd_participantes: 0, payment: null, valor:0, doacoes: new Array(7).fill(false),
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
        editando(){ return this.isEditingCafeComunhao; },
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
                header:'IBA-Cadastro de ' + this.edicao.nome +' '+ this.edicao.sobrenome,
                documentTitle:'Cadastro Café & Comunhão '+ this.edicao.nome +' '+ this.edicao.sobrenome,
                css:arrayCss,
                modalMessage:'Carregando...',
                onPrintDialogClose: ()=>{ this.isPrinting=false; },
                onError: (err) =>{ 
                    alert("Houve um erro ao imprimir esta ficha!!! Tente Novamente"); this.isPrinting=false;
                    $('#modalCafeComunhao').modal('show');
                },
            });
            this.isPrinting=false;
        },

        fechar(){
            this.matricula={
                nome: '', sobrenome: '', contato:'', qtd_participantes: null, payment: null, valor:null, doacoes: new Array(7).fill(false),
            };
            this.erros={}; $('#modalCafeComunhao').modal('hide');
        },

        cadastrar(){
            if(confirm('Deseja confirmar o Cadastro?')){
                this.isRequesting=true; this.erros={};
                axios.post('/cafeComunhao/atualizar',this.matricula)
                    .then(res=>{
                        this.isRequesting=false; this.sucesso=true; this.erros={};
                        alert('Cadastro efetuado com sucesso!!!');

                        // PIX
                        if(this.matricula.payment == true || this.matricula.payment == 1){
                            alert("Lembre-se de realizar o PIX no valor de R$"+ this.matricula.valor.toFixed(2)) 
                        }

                        $('#modalCafeComunhao').modal('hide');
                        this.matricula = {
                            nome: '', sobrenome: '', contato:'', qtd_participantes: null, payment: null, valor:null, doacoes: new Array(7).fill(false),
                        }

                        if(this.edicao!=null){
                            this.$emit('retornoCadastrosCafeComunhao', res.data); 
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