<template>
    <div>
		<div class="modal w3-animate-opacity" data-backdrop="static" id="modalSoPraCasais" tabindex="-1" role="dialog" aria-labelledby="ModalMatriculaLabel" aria-hidden="true">
		  	<div class="modal-dialog modal-lg" role="document">
		    	<div class="modal-content">
					<div class="modal-header">
                        <div class="d-flex justify-content-start">
                            <h5 class="modal-title" id="ModalMatriculaLabel">
                                    {{ (editando==null||editando==false)? 'Inscrição Só Pra Casais':
                                        'Editando Inscrição de '+ edicao.esposo.nome + ' e ' + edicao.esposa.nome }}
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

                        <p class="bd-lead" style="font-size:16px;">Esposo</p>
						<div class="row">
							<div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Nome do Esposo*</label>
									<input class="form-control form-control-sm" placeholder="Insira o Nome do esposo" type="text" v-model="matricula.esposo.nome" required>
                                    <small v-if="erros['esposo.nome']" class="text-danger" style="font-size:10px" :hidden="(!erros['esposo.nome'])">{{erros['esposo.nome'].toString()}}</small>
                                </div>
							</div>
							<div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Sobrenome do Esposo*</label>
									<input class="form-control form-control-sm" placeholder="Insira o Sobrenome do esposo" type="text" v-model="matricula.esposo.sobrenome" required>
                                    <small v-if="erros['esposo.sobrenome']" class="text-danger" style="font-size:10px" :hidden="(!erros['esposo.sobrenome'])">{{erros['esposo.sobrenome'].toString()}}</small>
                                </div>
							</div>
						</div>
                        <div class="row">
							<div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Data de Nascimento *</label>
									<input :class="'form-control form-control-sm'" placeholder="Data de Nascimento do esposo" type="date" v-model="matricula.esposo.nascimento">
                                    <small v-if="erros['esposo.nascimento']" class="text-danger" style="font-size:10px" :hidden="(!erros['esposo.nascimento'])">{{erros['esposo.nascimento'].toString()}}</small>
                                </div>
							</div>
							<div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Telefone *</label>
									<input class="form-control form-control-sm" v-model="matricula.esposo.telefone" v-mask="['(##) ####-####', '(##) #####-####']" 
                                        placeholder="Insira o Telefone do Esposo" type="tel" required>
                                    <small v-if="erros['esposo.telefone']" class="text-danger" style="font-size:10px" :hidden="(!erros['esposo.telefone'])">
                                        {{ erros['esposo.telefone'].toString() }}
                                    </small>
                                </div>
							</div>
						</div>

                        <div class="row">
                            <div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Igreja</label>
									<input class="form-control form-control-sm" placeholder="Insira o nome da igreja do esposo" type="text" v-model="matricula.esposo.igreja">
                                    <small v-if="erros['esposo.igreja']" class="text-danger" style="font-size:10px" :hidden="(!erros['esposo.igreja'])">{{erros['esposo.igreja'].toString()}}</small>
                                </div>
							</div>

                            <div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Membresia*</label>
                                    <select class="form-control form-control-sm" v-model="matricula.esposo.membresia">
                                        <option selected hidden value="">Escolha uma opção</option>
                                        <option v-for="(mem,idx) in membresias" :key="idx" :value="mem.key">{{mem.value}}</option>
                                    </select>
                                    <small v-if="erros['esposo.membresia']" class="text-danger" style="font-size:10px" :hidden="(!erros['esposo.membresia'])">{{erros['esposo.membresia'].toString()}}</small>
                                </div>
							</div>
                        </div>

                        <hr>
                        
                        <p class="bd-lead" style="font-size:16px;">Esposa</p>
                        <div class="row">
							<div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Nome da Esposa*</label>
									<input class="form-control form-control-sm" placeholder="Insira o Nome da esposa" type="text" v-model="matricula.esposa.nome" required>
                                    <small v-if="erros['esposa.nome']" class="text-danger" style="font-size:10px" :hidden="(!erros['esposa.nome'])">{{erros['esposa.nome'].toString()}}</small>
                                </div>
							</div>
							<div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Sobrenome da Esposa*</label>
									<input class="form-control form-control-sm" placeholder="Insira o Sobrenome da esposa" type="text" v-model="matricula.esposa.sobrenome" required>
                                    <small v-if="erros['esposa.sobrenome']" class="text-danger" style="font-size:10px" :hidden="(!erros['esposa.sobrenome'])">{{erros['esposa.sobrenome'].toString()}}</small>
                                </div>
							</div>
						</div>
                        <div class="row">
							<div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Data de Nascimento *</label>
									<input :class="'form-control form-control-sm'" placeholder="Data de Nascimento da Esposa" type="date" v-model="matricula.esposa.nascimento">
                                    <small v-if="erros['esposa.nascimento']" class="text-danger" style="font-size:10px" :hidden="(!erros['esposa.nascimento'])">{{erros['esposa.nascimento'].toString()}}</small>
                                </div>
							</div>
							<div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Telefone *</label>
									<input class="form-control form-control-sm" v-model="matricula.esposa.telefone" v-mask="['(##) ####-####', '(##) #####-####']" 
                                        placeholder="Insira o Telefone da Esposa" type="tel" required>
                                    <small v-if="erros['esposa.telefone']" class="text-danger" style="font-size:10px" :hidden="(!erros['esposa.telefone'])">
                                        {{ erros['esposa.telefone'].toString() }}
                                    </small>
                                </div>
							</div>
						</div>

                        <div class="row">
                            <div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Igreja</label>
									<input class="form-control form-control-sm" placeholder="Insira o nome da igreja da Esposa" type="text" v-model="matricula.esposa.igreja">
                                    <small v-if="erros['esposa.igreja']" class="text-danger" style="font-size:10px" :hidden="(!erros['esposa.igreja'])">{{erros['esposa.igreja'].toString()}}</small>
                                </div>
							</div>

                            <div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Membresia*</label>
                                    <select class="form-control form-control-sm" v-model="matricula.esposa.membresia">
                                        <option selected hidden value="">Escolha uma opção</option>
                                        <option v-for="(mem,idx) in membresias" :key="idx" :value="mem.key">{{mem.value}}</option>
                                    </select>
                                    <small v-if="erros['esposa.membresia']" class="text-danger" style="font-size:10px" :hidden="(!erros['esposa.igreja'])">{{erros['esposa.igreja'].toString()}}</small>
                                </div>
							</div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Data de Casamento *</label>
									<input :class="'form-control form-control-sm'" placeholder="Data de Casamento" type="date" v-model="matricula.casamento">
                                    <small v-if="erros['casamento']" class="text-danger" style="font-size:10px" :hidden="(!erros['casamento'])">{{erros['casamento'].toString()}}</small>
                                </div>
							</div>

                            <div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Filhos*</label>
                                    <input class="form-control form-control-sm" placeholder="Insira a quantidade de filhos" :min="0" :max="100" type="number" v-model="matricula.qntd_filhos" required>
                                    <small v-if="erros['qntd_filhos']" class="text-danger" style="font-size:10px" :hidden="(!erros['qntd_filhos'])">{{erros['qntd_filhos'].toString()}}</small>
                                </div>
							</div>
                        </div>

                        <div class="row">
                            <div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Logradouro*</label>
									<input class="form-control form-control-sm" placeholder="Insira o Logradouro" type="text"
                                            v-model="matricula.logradouro" required>
                                    <small v-if="erros['endereco.logradouro']" class="text-danger" style="font-size:10px" :hidden="(!erros['logradouro'])">{{erros['logradouro'].toString()}}</small>
								</div>
							</div>
                            <div class="col col-3 col-md-3">
                                <div class="form-group">
									<label>Nº da Casa*</label>
									<input class="form-control form-control-sm" placeholder="Insira o Número da Casa" type="text" v-model="matricula.num" required>
                                    <small v-if="erros['num']" class="text-danger" style="font-size:10px" :hidden="(!erros['num'])">{{erros['num'].toString()}}</small>
								</div>
							</div>
                            <div class="col col-3 col-md-3">
								<div class="form-group">
									<label>CEP</label>
									<input class="form-control form-control-sm" v-mask="'#####-###'" :placeholder="isPrinting==false?'Insira o CEP':''" type="text" 
                                        v-model="matricula.cep">
                                    <small v-if="erros['cep']" class="text-danger" style="font-size:10px" :hidden="(!erros['cep'])">{{erros['cep'].toString()}}</small>
								</div>
							</div>
                        </div>
                        <div class="row">
                            <div class="col col-4 col-md-4">
								<div class="form-group">
									<label>Cidade*</label>
									<input class="form-control form-control-sm" :placeholder="isPrinting==false?'Insira a Cidade':''" type="text" 
                                        v-model="matricula.cidade" required>
                                    <small v-if="erros['cidade']" class="text-danger" style="font-size:10px" :hidden="(!erros['cidade'])">{{erros['cidade'].toString()}}</small>
								</div>
							</div>
                            <div class="col col-4 col-md-4">
								<div class="form-group">
									<label>Bairro*</label>
									<input class="form-control form-control-sm" :placeholder="isPrinting==false?'Insira o Bairro':''" type="text" 
                                        v-model="matricula.bairro" required>
                                    <small v-if="erros['bairro']" class="text-danger" style="font-size:10px" :hidden="(!erros['bairro'])">{{erros['bairro'].toString()}}</small>
								</div>
							</div>
                            <div class="col col-4 col-md-4">
								<div class="form-group">
									<label>Complemento</label>
                                    <textarea class="form form-control" :placeholder="isPrinting==false?'Complemento (opcional)':''" type="text" rows="1" 
                                        v-model="matricula.complemento"></textarea>
                                    <small v-if="erros['complemento']" class="text-danger" style="font-size:10px" :hidden="(!erros['complemento'])">{{erros['complemento'].toString()}}</small>
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
    name:'MatriculaSoPraCasais',

    components:{ TheMask },
    directives:{ print },

    props:{
        edicao:{ type:Object, default:null },
        isEditingCasais:{ type:Boolean, default:null }
    },

    data() {
        return {
            isRequesting:false, sucesso:false, erros:{}, isPrinting:false,
            matricula: {
                esposo:{
                    nome:'', sobrenome:'', igreja:'', telefone:'', nascimento:'', membresia :'',
                },
                esposa:{
                    nome:'', sobrenome:'', igreja:'', telefone:'', nascimento:'', membresia :'',
                },
                logradouro:'', bairro:'', num:'', cep:'', complemento:'', cidade:'',
            },
            membresias:[
                {key:'m', value:'Membro'}, {key:'c', value:'Congregado'}, {key:'s', value:'Sem Igreja'}, 
            ],
        }
    },

    watch:{
        ['matricula.cep'](val,old){
            if(val!='' && val!=old && val!=null && val!=undefined && (val.replace(/\s/g, '').length) &&
                val.indexOf('-')!=-1 && val.length == 9){
                    this.getCepInfo();
            }
        },
        edicao(val){
            if(val!=null && val!={}){
                this.matricula=Object.assign({},val);
            }
        },
    },

    computed:{
        editando(){ return this.isEditingCasais; },
        matriculaClone(){ 
            this.matricula=Object.assign({},this.edicao); return 'foi';
        }
    },

    methods: {
        getCepInfo: _.debounce(function(){
            if(this.matricula.cep!=''&&this.matricula.cep!=null){
                axios.get('http://viacep.com.br/ws/'+this.matricula.cep+'/json')
                    .then(res=>{
                        this.isRequesting=false; this.erros={};
                        this.matricula.logradouro = res.data.logradouro;
                        this.matricula.complemento = res.data.complemento;
                        this.matricula.bairro = res.data.bairro;
                        this.matricula.cidade = res.data.localidade;
                    })
                    .catch(err=>{ 
                        this.isRequesting=false; console.error(err); 
                        this.erros.cep=['O CEP informado é inválido!']; 
                    })
            }
        },1500),

        imprimirFicha(){
            this.isPrinting = true;
            var arrayCss=[
                "https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css",
            ]
            printJS({
                printable:'corpo_modal', 
                type:'html',
                header:'IBA-Inscrição de ' + this.edicao.esposo.nome +' '+ this.edicao.esposo.sobrenome + ' e ' 
                    + this.edicao.esposa.nome +' '+ this.edicao.esposa.sobrenome,
                documentTitle:'Inscrição Só pra Casais de '+ this.edicao.esposo.nome +' '+ this.edicao.esposo.sobrenome + ' e ' 
                    + this.edicao.esposa.nome +' '+ this.edicao.esposa.sobrenome,
                css:arrayCss,
                modalMessage:'Carregando...',
                onPrintDialogClose: ()=>{ this.isPrinting=false; },
                onError: (err) =>{ 
                    alert("Houve um erro ao imprimir esta ficha!!! Tente Novamente"); this.isPrinting=false;
                    $('#modalSoPraCasais').modal('show');
                },
            });
            this.isPrinting=false;
        },

        fechar(){
            this.matricula={
                esposo:{
                    nome:'', sobrenome:'', igreja:'', telefone:'', nascimento:'', membresia :'',
                },
                esposa:{
                    nome:'', sobrenome:'', igreja:'', telefone:'', nascimento:'', membresia :'',
                },
                logradouro:'', bairro:'', num:'', cep:'', complemento:'', cidade:'',
            };
            this.erros={}; $('#modalSoPraCasais').modal('hide');
        },

        cadastrar(){
            if(confirm('Deseja confirmar a inscrição?')){
                this.isRequesting=true; this.erros={};
                axios.post('/casais/atualizar',this.matricula)
                    .then(res=>{
                        this.isRequesting=false; this.sucesso=true; this.erros={};
                        alert('Inscrição efetuada com sucesso!!!'); $('#modalSoPraCasais').modal('hide');

                        if(this.edicao!=null){
                            this.$emit('retornoInscricoesSoPraCasais', res.data); 
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