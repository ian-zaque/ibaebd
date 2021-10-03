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
									<input class="form-control form-control-sm" placeholder="Insira seu Nome" type="text" v-model="matricula.nome" required>
                                    <small v-if="erros.nome" class="text-danger" style="font-size:10px" :hidden="(!erros.nome)">{{erros.nome.toString()}}</small>
                                </div>
							</div>
							<div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Sobrenome da Criança*</label>
									<input class="form-control form-control-sm" placeholder="Insira seu Sobrenome" type="text" v-model="matricula.sobrenome" required>
                                    <small v-if="erros.sobrenome" class="text-danger" style="font-size:10px" :hidden="(!erros.sobrenome)">{{erros.sobrenome.toString()}}</small>
                                </div>
							</div>
						</div>
                    </form>
                    </div>
                    <div class="row">
                        <div class="col col-12 col-md-12">
                            <div style="margin-right:15px;">
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
            matricula:{
                nome:'', sobrenome:'', nascimento:'',
            },
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
                    $('#modalMatricula').modal('show');
                },
            });
            this.isPrinting=false;
        },

        fechar(){
            this.matricula={
                nome:'', sobrenome:'', nascimento:'',
            };
            this.erros={}; $('#modalMatricula').modal('hide');
        },

        cadastrar(){
            if(confirm('Deseja confirmar a matrícula?')){
                this.isRequesting=true; this.erros={};
                axios.post('/atualizar',this.matricula)
                    .then(res=>{
                        this.isRequesting=false; this.sucesso=true; this.erros={};
                        alert('Matrícula efetuada com sucesso!!!'); $('#modalMatricula').modal('hide');
                        if(this.edicao!=null){ this.$emit('retornoMatriculas', res.data); }
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