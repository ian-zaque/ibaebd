<template>
    <div>
		<div class="modal w3-animate-opacity" data-backdrop="static" id="modalEbdMusicos" tabindex="-1" role="dialog" aria-labelledby="ModalMatriculaLabel" aria-hidden="true">
		  	<div class="modal-dialog modal-lg" role="document">
		    	<div class="modal-content">
					<div class="modal-header">
                        <div class="d-flex justify-content-start">
                            <h5 class="modal-title" id="ModalMatriculaLabel">
                                    {{(editando==null||editando==false)? 'Matrícula EBD Músicos':
                                        'Editando Matrícula de '+ edicao.nome}}
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
									<label>Nome*</label>
									<input class="form-control form-control-sm" placeholder="Insira seu Nome" type="text" v-model="matricula.nome" required>
                                    <small v-if="erros.nome" class="text-danger" style="font-size:10px" :hidden="(!erros.nome)">{{erros.nome.toString()}}</small>
                                </div>
							</div>
							<div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Sobrenome*</label>
									<input class="form-control form-control-sm" placeholder="Insira seu Sobrenome" type="text" v-model="matricula.sobrenome" required>
                                    <small v-if="erros.sobrenome" class="text-danger" style="font-size:10px" :hidden="(!erros.sobrenome)">{{erros.sobrenome.toString()}}</small>
                                </div>
							</div>
						</div>

						<div class="row">
                            <div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Data de Nascimento*</label>
									<input class="form-control form-control-sm" placeholder="Insira sua data de nascimento" type="date" v-model="matricula.nascimento" required>
                                    <small v-if="erros.nascimento" class="text-danger" style="font-size:10px" :hidden="(!erros.nascimento)">{{erros.nascimento.toString()}}</small>
								</div>
							</div>
                            <div class="col col-6 col-md-6">
								<div class="form-group">
									<label>E-mail</label>
									<input class="form-control form-control-sm" :placeholder="isPrinting==false?'Insira seu E-mail':''" type="email" 
                                            v-model="matricula.email" required>
                                    <small v-if="erros.email" class="text-danger" style="font-size:10px" :hidden="(!erros.email)">{{erros.email.toString()}}</small>
                                </div>
							</div>
						</div>

                        <div class="row">
                            <div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Telefone</label>
									<input class="form-control form-control-sm" :placeholder="isPrinting==false?'Insira seu telefone':''" 
                                        v-model="matricula.telefone" v-mask="['(##) ####-####', '(##) #####-####']"  type="tel">
                                    <small v-if="erros.telefone" class="text-danger" style="font-size:10px" :hidden="(!erros.telefone)">{{erros.telefone.toString()}}</small>
								</div>
							</div>
                            <div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Preferência de Horário</label>
									<select class="form-control form-control-sm" v-model="matricula.preferencia_horario">
                                        <option selected hidden value="">Selecione seu horário de preferência da classe de EBD</option>
                                        <option selected value="1">Terças às 19h30</option>
                                        <option selected value="2">Sábados às 15h</option>
                                        <option selected value="3">Domingo às 9h</option>
                                    </select>
                                    <small v-if="erros.preferencia_horario" class="text-danger" style="font-size:10px" :hidden="(!erros.preferencia_horario)">{{erros.preferencia_horario.toString()}}</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col col-6 col-md-6">
								<div class="form-group">
									<label>De qual(is) grupo(s) do MMA você faz parte?</label>
									<select class="form-control form-control-sm" multiple v-model="matricula.grupo_mma">
                                        <option selected hidden value="">Selecione o grupo musical que participa</option>
                                        <option v-for="(grupo,idx) in grupos_mma" :key="idx" :value="grupo">{{grupo}}</option>
                                    </select>
                                    <small style="font-size:9px">Selecione e arraste para escolher mais de um</small>
                                    <small v-if="erros.grupo_mma" class="text-danger" style="font-size:10px" :hidden="(!erros.grupo_mma)">{{erros.grupo_mma.toString()}}</small>
                                </div>
							</div>
                            
                            <div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Há quantos anos participa?</label>
									<input class="form-control form-control-sm" type="number"  placeholder="Há quantos anos?" v-model="matricula.tempo_mma" required>
                                    <small v-if="erros.tempo_mma" class="text-danger" style="font-size:10px" :hidden="(!erros.tempo_mma)">{{erros.tempo_mma.toString()}}</small>
                                </div>
							</div>
                        </div>

                        <div class="row">
                            <div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Qual(is) instrumento(s) que toca?</label>
									<select class="form-control form-control-sm" multiple v-model="matricula.instrumento">
                                        <option selected hidden value="">Selecione o instrumento</option>
                                        <option selected hidden :value="null">Selecione o instrumento</option>
                                        <option v-for="(inst,idx) in instrumentos" :key="idx" :value="inst">{{inst}}</option>
                                    </select>
                                    <small style="font-size:9px">Selecione e arraste para escolher mais de um</small>
                                    <small v-if="erros.instrumento" class="text-danger" style="font-size:10px" :hidden="(!erros.instrumento)">{{erros.instrumento.toString()}}</small>
                                </div>
							</div>
                            
                            <div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Qual voz canta (naipe vocal)?</label>
									<select class="form-control form-control-sm" v-model="matricula.naipe_vocal">
                                        <option selected hidden value="">Selecione o naipe vocal</option>
                                        <option selected hidden :value="null">Selecione o naipe vocal</option>
                                        <option v-for="(naipe,idx) in naipes_vocais" :key="idx" :value="naipe">{{naipe}}</option>
                                    </select>
                                    <small v-if="erros.naipe_vocal" class="text-danger" style="font-size:10px" :hidden="(!erros.naipe_vocal)">{{erros.naipe_vocal.toString()}}</small>
                                </div>
							</div>
                        </div>

                        <div class="row">
                            <div class="col col-6 col-md-6">
								<div class="form-group">
									<label>De qual PGM você faz parte?</label>
									<input class="form-control form-control-sm" placeholder="Insira o nome de seu PGM" type="text" v-model="matricula.pgm" required>
                                    <small v-if="erros.pgm" class="text-danger" style="font-size:10px" :hidden="(!erros.pgm)">{{erros.pgm.toString()}}</small>
                                </div>
							</div>
                            
                            <div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Há quantos anos vc faz parte de um PGM?</label>
									<input class="form-control form-control-sm" type="number"  placeholder="Há quantos anos?" v-model="matricula.tempo_pgm" required>
                                    <small v-if="erros.tempo_pgm" class="text-danger" style="font-size:10px" :hidden="(!erros.tempo_pgm)">{{erros.tempo_pgm.toString()}}</small>
                                </div>
							</div>
                        </div>

                        <div class="row">
                            <div class="col col-12 col-md-12">
                                <div class="form-group">
                                    <label>Escreva aqui um versículo bíblico da sua preferência</label>
                                    <textarea v-model="matricula.versiculo" class="form-control form-control-sm" rows="2" placeholder="Versículo que fala ao seu coração quanto à vida de adoração" required></textarea>
                                    <small v-if="erros.versiculo" class="text-danger" style="font-size:10px" :hidden="(!erros.versiculo)">{{erros.versiculo.toString()}}</small>
                                </div>
                            </div>
                        </div>

                    </form>
                    </div>

                    <!-- <div class="row">
                        <div class="col col-12 col-md-12">
                            <div style="margin-right:15px;">
                                <p class="small text-danger">*Obrigatório!</p>
                            </div>
                        </div>
                    </div> -->

					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" @click="fechar" :disabled="isRequesting==true" data-dismiss="modal">Fechar</button> 
						<button type="button" class="btn btn-primary" @click="cadastrar" :disabled="isRequesting==true">
                            {{ (editando==null||editando==false) ? 'Matricular':'Atualizar'}}
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
    name:'MatriculaEbdMusicos',

    components:{ TheMask },
    directives:{ print },

    props:{
        edicao:{ type:Object, default:null },
        isEditingEbdMusicos:{ type:Boolean, default:null }
    },

    data() {
        return {
            isRequesting:false, sucesso:false, erros:{}, isPrinting:false,
            matricula:{
               nome: '', sobrenome: '', nascimento:'', email:'', telefone:'', grupo_mma:[], tempo_mma:'', instrumento:[],
               naipe_vocal:'', pgm:'', tempo_pgm:'', preferencia_horario:'', versiculo:'',
            },
            grupos_mma: [
                'Adoradores', 'Cantares', 'Musicart', 'Provérbios 16', 'Salmodiadores',
            ],
            instrumentos:[
                'Piano', 'Teclado', 'Violão', 'Contrabaixo', 'Guitarra', 'Saxofone', 'Bateria', 'Percussão',
            ],
            naipes_vocais:[
                'Soprano', 'Contralto', 'Tenor', 'Barítono',
            ], 
        }
    },

    watch:{
        edicao(val){
            if(val!=null && val!={}){
                this.matricula=Object.assign({},val);
            }
            else{
                this.matricula = {
                    nome: '', sobrenome: '', nascimento:'', email:'', telefone:'', grupo_mma:[], tempo_mma:'', instrumento:[],
                    naipe_vocal:'', pgm:'', tempo_pgm:'', preferencia_horario:'', versiculo:'',
                }
            }
        },
    },

    computed:{
        editando(){ return this.isEditingEbdMusicos; },
        // matriculaClone(){ 
        //     this.matricula=Object.assign({},this.edicao); return 'foi';
        // }
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
                header:'IBA-Matrícula de ' + this.edicao.nome +' '+ this.edicao.sobrenome,
                documentTitle:'Ficha de Matrícula de '+ this.edicao.nome +' '+ this.edicao.sobrenome,
                css:arrayCss,
                modalMessage:'Carregando...',
                onPrintDialogClose: ()=>{ this.isPrinting=false; },
                onError: (err) =>{ 
                    alert("Houve um erro ao imprimir esta ficha!!! Tente Novamente"); this.isPrinting=false;
                    $('#modalEbdMusicos').modal('show');
                },
            });
            this.isPrinting=false;
        },

        fechar(){
            this.matricula = {
               nome: '', sobrenome: '', nascimento:'', email:'', telefone:'', grupo_mma:[], tempo_mma:'', instrumento:[],
               naipe_vocal:'', pgm:'', tempo_pgm:'', preferencia_horario:'', versiculo:'',
            }
            this.erros={}; $('#modalEbdMusicos').modal('hide');
        },

        cadastrar(){
            if(confirm('Deseja confirmar a matrícula?')){
                this.isRequesting=true; this.erros={};
                axios.post('/ebdMusicos/atualizar',this.matricula)
                    .then(res=>{
                        this.isRequesting=false; this.sucesso=true; this.erros={};
                        alert('Matrícula efetuada com sucesso!!!'); $('#modalEbdMusicos').modal('hide');
                        if(this.edicao!=null){ this.$emit('retornoInscricoesEbdMusicos', res.data); }
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