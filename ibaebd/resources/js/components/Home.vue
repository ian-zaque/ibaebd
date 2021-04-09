<template>
    <div class="container" id="">
         <div class="card text-center" style="border-radius:15px;">
            <div class="card-body">
                <h5 class="card-title" style="font-size:40px;">Igreja Batista Alvorada</h5>
                <p class="card-text" style="font-size:20px;">Feira de Santana - Bahia</p>
                <p class="card-text " style="font-size:40px;">EBDiscipuladora</p>

                <div class="container">
                    <img src="imagens/logo_iba.png" style="margin-bottom:15px;" width="120px" height="170px" class="img-fluid float-left">
                    <img src="imagens/logo_ebd.jpg" style="margin-top:10px; margin-right:-20px;" width="170px" height="220px" class="img-fluid float-right">
                </div>
                
                <div class="d-grid gap-2">
                    <button class="btn btn-danger btn-block" @click="abrirModalMatricula()" id="btn_matricula" style="font-size:30px; background-color:#D30100;" type="button">
                        Matricule-se!
                    </button>
                </div>
            </div>
        </div>

       <!-- MODAL MATRICULA-->
		<div class="modal w3-animate-opacity" id="modalMatricula" tabindex="-1" role="dialog" aria-labelledby="ModalMatriculaLabel" aria-hidden="true">
		  	<div class="modal-dialog  modal-lg" role="document">
		    	<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="ModalMatriculaLabel">Matrícula EBDiscipuladora</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p class="alert alert-danger" v-for="(error, ie) in erros" :key="ie">
							<button type="button" class="close" data-dismiss="alert" aria-label="close"><i class="ion-ios-close-empty"></i></button>
							{{ error }}
						</p>
						<div class="row">
							<div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Nome</label>
									<input class="form-control form-control-sm" placeholder="Insira seu Nome" type="text" v-model="matricula.nome" required>
								</div>
							</div>
							<div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Sobrenome</label>
									<input class="form-control form-control-sm" placeholder="Insira seu Sobrenome" type="text" v-model="matricula.sobrenome" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col col-6 col-md-6">
								<div class="form-group">
									<label>CPF</label>
									<input class="form-control form-control-sm" v-mask="['###.###.###-##']" placeholder="Insira seu CPF" type="text" 
                                            v-model="matricula.cpf" required>
								</div>
							</div>
                            <div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Data de Nascimento</label>
									<input class="form-control form-control-sm" placeholder="Insira sua data de nascimento" type="date" 
                                            v-model="matricula.nascimento" required>
								</div>
							</div>
						</div>
                        <div class="row">
                            <div class="col col-4 col-md-4">
								<div class="form-group">
									<label>RG</label>
									<input class="form-control form-control-sm" v-mask="['##.###.###-#','##.###.###-##']" placeholder="Insira seu RG"
                                            type="text" v-model="matricula.rg" required>
								</div>
							</div>
                            <div class="col col-4 col-md-4">
								<div class="form-group">
									<label>Órgão Emissor</label>
                                    <select class="form-control form-control-sm" v-model="matricula.orgao_emissor" required>
                                        <option selected hidden value="">Selecione o Órgão Emissor</option>
                                        <option v-for="(org,idx) in orgaos_emissores" :key="idx" :value="org.sigla">{{org.sigla +' - '+ org.nome}}</option>
                                    </select>
                                </div>
							</div>
                            <div class="col col-4 col-md-4">
								<div class="form-group">
									<label>UF</label>
									<select class="form-control form-control-sm" v-model="matricula.uf">
                                        <option selected hidden value="">Selecione a Unidade Federal</option>
                                        <option v-for="(u,idx) in ufs" :key="idx" :value="u.key">{{u.key +' - '+ u.value}}</option>
                                    </select>
								</div>
							</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col col-3 col-md-3">
                                <label>Sexo</label>
								<div class="form-group">
									<div class="form-check form-check-inline">
                                        <input v-model="matricula.sexo" class="form-check-input" type="radio" name="radio_btn_sexoF" id="radio_btn_sexoF" :value="true">
                                        <label class="form-check-label" for="radio_btn_sexoF">Feminino</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input v-model="matricula.sexo" class="form-check-input" type="radio" name="radio_btn_sexoM" id="radio_btn_sexoM" :value="false">
                                        <label class="form-check-label" for="radio_btn_sexoM">Masculino</label>
                                    </div>
								</div>
							</div>
                            <div class="col col-3 col-md-3">
                                <label>Já é evangélico?</label>
								<div class="form-group">
									<div class="form-check form-check-inline">
                                        <input v-model="matricula.isEvangelico" class="form-check-input" type="radio" name="radio_btn_evglS" id="radio_btn_evglS" :value="true">
                                        <label class="form-check-label" for="radio_btn_evglS">Sim</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input v-model="matricula.isEvangelico" class="form-check-input" type="radio" name="radio_btn_evglN" id="radio_btn_evglN" :value="false">
                                        <label class="form-check-label" for="radio_btn_evglN">Não</label>
                                    </div>
								</div>
							</div>
                            <div class="col col-3 col-md-3">
                                <label>Já é membro da IBA?</label>
								<div class="form-group">
									<div class="form-check form-check-inline">
                                        <input v-model="matricula.isMembro" class="form-check-input" type="radio" name="radio_btn_mbrS" id="radio_btn_mbrS" :value="true">
                                        <label class="form-check-label" for="radio_btn_mbrS">Sim</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input v-model="matricula.isMembro" class="form-check-input" type="radio" name="radio_btn_mbrN" id="radio_btn_mbrN" :value="false">
                                        <label class="form-check-label" for="radio_btn_mbrN">Não</label>
                                    </div>
								</div>
							</div>
                            <div class="col col-3 col-md-3">
								<div class="form-group">
									<label>Data de Conversão</label>
									<input class="form-control form-control-sm" placeholder="Data de conversão (opcional)" type="date" v-model="matricula.conversao">
								</div>
							</div>
                        </div>
                        <div class="row">
                            <div class="col col-3 col-md-3">
								<div class="form-group">
									<label>E-mail</label>
									<input class="form-control form-control-sm" placeholder="Insira seu E-mail" type="email" v-model="matricula.email" required>
								</div>
                            </div>
                            <div class="col col-3 col-md-3">
								<div class="form-group">
									<label>Telefone 1</label>
									<input class="form-control form-control-sm" v-mask="['(##) ####-####', '(##) #####-####']" placeholder="Insira seu Telefone" type="tel" required>
                                </div>
                            </div>
                            <div class="col col-3 col-md-3">
								<div class="form-group">
									<label>Telefone 2</label>
									<input class="form-control form-control-sm" v-mask="['(##) ####-####', '(##) #####-####']" placeholder="Outro telefone (opcional)" type="tel" v-model="matricula.telefones.tel2">
								</div>
                            </div>
                            <div class="col col-3 col-md-3">
								<div class="form-group">
									<label>Classe da EBD</label>
									<select class="form-control form-control-sm" v-model="matricula.classe">
                                        <option selected hidden value="">Selecione a Classe da EBD</option>
                                        <option selected :value="'batismo'">Classe de Batismo</option>
                                    </select>
								</div>
							</div>
					    </div>
                        <hr>
                        <div class="row">
                            <div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Logradouro</label>
									<input class="form-control form-control-sm" placeholder="Insira o Logradouro" type="text" v-model="matricula.endereco.logradouro" required>
								</div>
							</div>
                            <div class="col col-3 col-md-3">
                                <div class="form-group">
									<label>CEP</label>
									<input class="form-control form-control-sm" v-mask="'#####-###'" placeholder="Insira o CEP" type="text" v-model="matricula.endereco.cep">
								</div>
							</div>
                            <div class="col col-3 col-md-3">
								<div class="form-group">
									<label>Número</label>
									<input class="form-control form-control-sm" placeholder="Insira o Número" type="number" v-model="matricula.endereco.num" required>
								</div>
							</div>
                        </div>
                        <div class="row">
                            <div class="col col-4 col-md-4">
								<div class="form-group">
									<label>Cidade</label>
									<input class="form-control form-control-sm" placeholder="Insira a Cidade" type="text" v-model="matricula.endereco.local" required>
								</div>
							</div>
                            <div class="col col-4 col-md-4">
								<div class="form-group">
									<label>Bairro</label>
									<input class="form-control form-control-sm" placeholder="Insira o Bairro" type="text" v-model="matricula.endereco.bairro" required>
								</div>
							</div>
                            <div class="col col-4 col-md-4">
								<div class="form-group">
									<label>Complemento</label>
                                    <textarea class="form form-control" placeholder="Complemento (opcional)" type="text" rows="1" v-model="matricula.endereco.complemento"></textarea>
								</div>
							</div>
                        </div>
                    </div>

					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button> 
						<button type="button" :loading="isRequesting" class="btn btn-primary">Matricular-se</button>
					</div>
		    	</div>
		  	</div>
		</div>
		<!--Fim do MODAL MATRICULA -->
    </div>
</template>
<script>
import {TheMask} from 'vue-the-mask'

export default {
    name:'Home',

    components:{ TheMask },

    data() {
        return {
            isRequesting:false, erros:[], 
            matricula:{
                nome:'', sobrenome:'', cpf:'', rg:'', orgao_emissor:'', uf:'', nascimento:'',
                email:'', isEvangelico:false, isMembro:false, classe:'batismo', sexo:false, conversao:'',
                telefones:{tel1:'',tel2:'',}, endereco:{logradouro:'', bairro:'', num:'', cep:'', complemento:'', local:''},
            },
            orgaos_emissores:[
                {sigla:'SSP', nome:'Secretaria de Segurança Pública'}, {sigla:'PM', nome:'Polícia Militar'},
                {sigla:'PC', nome:'Polícia Cívil'}, {sigla:'POF', nome:'Polícia Federal'}, {sigla:'POM', nome:'Polícia Militar'},
                {sigla:'MMA', nome:'Ministério da Marinha'}, {sigla:'MAE', nome:'Ministério da Aeronáutica'}, {sigla:'MEX', nome:'Ministério do Exército'},
                {sigla:'CNH', nome:'Carteira Nacional de Habilitação'}, {sigla:'DIC', nome:'Diretoria de Identificação Civil'}, 
                {sigla:'CTPS', nome:'Carteira de Trabaho e Previdência Social'}, {sigla:'MTE', nome:'Ministério do Trabalho e Emprego'},
                {sigla:'FGTS', nome:'Fundo de Garantia do Tempo de Serviço'}, {sigla:'IFP', nome:'Instituto Félix Pacheco'},
                {sigla:'IPF', nome:'Instituto Pereira Faustino'}, {sigla:'IML', nome:'Instituto Médico-Legal'},
                {sigla:'SES', nome:'Carteira de Estrangeiro'}, {sigla:'SJS', nome:'Secretaria da Justiça e Segurança'},
                {sigla:'SJTS', nome:'Secretaria da Justiça do Trabalho e Segurança'}, {sigla:'ZZZ', nome:'Outros(inclusive exterior)'},
            ],
            ufs:[
                {key:"AC", value:"Acre"}, {key:"AL", value:"Alagoas"}, {key:"AP", value:"Amapá"}, {key:"AM", value:"Amazonas"},
                {key:"BA", value:"Bahia"}, {key:"CE", value:"Ceará"}, {key:"DF", value:"Distrito Federal"},
                {key:"ES", value:"Espírito Santo"}, {key: "GO", value:"Goiás"}, {key:"MA", value:"Maranhão"},
                {key: "MT", value:"Mato Grosso"}, {key:"MS", value:"Mato Grosso do Sul"}, {key:"MG", value:"Minas Gerais"},
                {key:"PA", value:"Pará"}, {key:"PB", value:"Paraíba"}, { key: "PR", value: "Paraná" },
                { key: "PE", value: "Pernambuco" }, { key: "PI", value: "Piauí" }, { key: "RJ", value: "Rio de Janeiro" },
                { key: "RN", value: "Rio Grande do Norte" }, { key: "RS", value: "Rio Grande do Sul" }, { key: "RO", value: "Rondônia" },
                { key: "RR", value: "Roraima" }, { key: "SC", value: "Santa Catarina" }, { key: "SP", value: "São Paulo" },
                { key: "SE", value: "Sergipe" }, { key: "TO", value: "Tocantins" }
            ]
        }
    },

    watch:{
        ['matricula.endereco.cep'](val,old){
            if(val!='' && val!=old && val!=null && val!=undefined && (val.replace(/\s/g, '').length) && val.indexOf('-')!=-1 && val.length == 9){
                this.getCepInfo();
            }
        }
    },

    methods: {
        abrirModalMatricula(){
            this.matricula={
                nome:'', sobrenome:'', cpf:'', rg:'', orgao_emissor:'', uf:'', nascimento:'',
                email:'', isEvangelico:false, isMembro:false, classe:'batismo', sexo:false, conversao:'',
                telefones:{tel1:'',tel2:'',}, endereco:{logradouro:'', bairro:'', num:'', complemento:'', local:'',},
            };
            $('#modalMatricula').modal('show');
        },

        getCepInfo: _.debounce(function(){
            this.isRequesting=true;
            axios.get('http://viacep.com.br/ws/'+this.matricula.endereco.cep+'/json')
                .then(res=>{
                    console.log(res); this.isRequesting=false; this.erros=[];
                    this.matricula.endereco.logradouro = res.data.logradouro;
                    this.matricula.endereco.complemento = res.data.complemento;
                    this.matricula.endereco.bairro = res.data.bairro;
                    this.matricula.endereco.local = res.data.localidade;
                })
                .catch(err=>{
                    this.isRequesting=false; console.error(err); this.erros=err;
                })
        },1000),

        cadastrar(){
            if(confirm('Deseja confirmar a matrícula?')){
                this.isRequesting=true;
                axios.post('',this.matricula)
                    .then(()=>{
                        this.isRequesting=false;
                    })
                    .catch(err=>{
                        this.isRequesting=false; console.error(err); this.erros=err;
                    })
            }
        },

    },

    mounted(){
    },

}
</script>
