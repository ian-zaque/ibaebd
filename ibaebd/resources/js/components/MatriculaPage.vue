<template>
    <div>
		<div class="modal w3-animate-opacity" data-backdrop="static" id="modalMatricula" tabindex="-1" role="dialog" aria-labelledby="ModalMatriculaLabel" aria-hidden="true">
		  	<div class="modal-dialog modal-lg" role="document">
		    	<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="ModalMatriculaLabel">
                            {{edicao.id==null||edicao.id==undefined?'Matrícula EBDiscipuladora':'Editando Matricula de '+ edicao.nome}}
                        </h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div  class="modal-body">
                    <form action="#" id="corpo_modal">
						<div class="row">
							<div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Nome *</label>
									<input class="form-control form-control-sm" placeholder="Insira seu Nome" type="text" v-model="matricula.nome" required>
                                    <small v-if="erros.nome" class="text-danger" style="font-size:10px" :hidden="(!erros.nome)">{{erros.nome.toString()}}</small>
                                </div>
							</div>
							<div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Sobrenome *</label>
									<input class="form-control form-control-sm" placeholder="Insira seu Sobrenome" type="text" v-model="matricula.sobrenome" required>
                                    <small v-if="erros.sobrenome" class="text-danger" style="font-size:10px" :hidden="(!erros.sobrenome)">{{erros.sobrenome.toString()}}</small>
                                </div>
							</div>
						</div>
						<div class="row">
							<div class="col col-6 col-md-6">
								<div class="form-group">
									<label>CPF *</label>
									<input class="form-control form-control-sm" v-mask="['###.###.###-##']" placeholder="Insira seu CPF" type="text" 
                                            v-model="matricula.cpf" required>
                                    <small v-if="erros.cpf" class="text-danger" style="font-size:10px" :hidden="(!erros.cpf)">{{erros.cpf.toString()}}</small>
								</div>
							</div>
                            <div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Data de Nascimento *</label>
									<input class="form-control form-control-sm" placeholder="Insira sua data de nascimento" type="date" 
                                            v-model="matricula.nascimento" required>
                                    <small v-if="erros.nascimento" class="text-danger" style="font-size:10px" :hidden="(!erros.nascimento)">{{erros.nascimento.toString()}}</small>
								</div>
							</div>
						</div>
                        <div class="row">
                            <div class="col col-4 col-md-4">
								<div class="form-group">
									<label>RG *</label>
									<input class="form-control form-control-sm" v-mask="['##.###.###-#','##.###.###-##']" placeholder="Insira seu RG"
                                            type="text" v-model="matricula.rg" required>
                                    <small v-if="erros.rg" class="text-danger" style="font-size:10px" :hidden="(!erros.rg)">{{erros.rg.toString()}}</small>
								</div>
							</div>
                            <div class="col col-4 col-md-4">
								<div class="form-group">
									<label>Órgão Emissor *</label>
                                    <select class="form-control form-control-sm" v-model="matricula.orgao_emissor" required>
                                        <option selected hidden value="">Selecione o Órgão Emissor</option>
                                        <option v-for="(org,idx) in orgaos_emissores" :key="idx" :value="org.sigla">{{org.sigla +' - '+ org.nome}}</option>
                                    </select>
                                    <small v-if="erros.orgao_emissor" class="text-danger" style="font-size:10px" :hidden="(!erros.orgao_emissor)">{{erros.orgao_emissor.toString()}}</small>
                                </div>
							</div>
                            <div class="col col-4 col-md-4">
								<div class="form-group">
									<label>UF *</label>
									<select class="form-control form-control-sm" v-model="matricula.uf">
                                        <option selected hidden value="">Selecione a Unidade Federal</option>
                                        <option v-for="(u,idx) in ufs" :key="idx" :value="u.key">{{u.key +' - '+ u.value}}</option>
                                    </select>
                                    <small v-if="erros.uf" class="text-danger" style="font-size:10px" :hidden="(!erros.uf)">{{erros.uf.toString()}}</small>
								</div>
							</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col col-3 col-md-3">
                                <label>Sexo*</label>
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
                                <small v-if="erros.sexo" class="text-danger" style="font-size:10px" :hidden="(!erros.sexo)">{{erros.sexo.toString()}}</small>
							</div>
                            <div class="col col-3 col-md-3">
                                <label>Sou evangélico?*</label>
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
                                <small v-if="erros.isEvangelico" class="text-danger" style="font-size:10px" :hidden="(!erros.isEvangelico)">{{erros.isEvangelico.toString()}}</small>
							</div>
                            <div class="col col-3 col-md-3">
                                <label>Sou Membro da IBA?*</label>
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
                                <small v-if="erros.isMembro" class="text-danger" style="font-size:10px" :hidden="(!erros.isMembro)">{{erros.isMembro.toString()}}</small>
							</div>
                            <div class="col col-3 col-md-3">
								<div class="form-group">
									<label>Data de Conversão</label>
									<input :class="'form-control form-control-sm'" placeholder="Data de conversão (opcional)" type="date" v-model="matricula.conversao">
                                    <small v-if="erros.conversao" class="text-danger" style="font-size:10px" :hidden="(!erros.conversao)">{{erros.conversao.toString()}}</small>
                                </div>
							</div>
                        </div>
                        <div class="row">
                            <div class="col col-3 col-md-3">
								<div class="form-group">
									<label>E-mail</label>
									<input class="form-control form-control-sm" placeholder="Insira seu E-mail" type="email" v-model="matricula.email" required>
                                    <small v-if="erros.email" class="text-danger" style="font-size:10px" :hidden="(!erros.email)">{{erros.email.toString()}}</small>
                                </div>
                            </div>
                            <div class="col col-3 col-md-3">
								<div class="form-group">
									<label>Telefone 1 *</label>
									<input class="form-control form-control-sm" v-model="matricula.telefones.tel1"
                                            v-mask="['(##) ####-####', '(##) #####-####']" placeholder="Insira seu Telefone" type="tel" required>
                                    <small v-if="erros['telefones.tel1']" class="text-danger" style="font-size:10px" :hidden="(!erros['telefones.tel1'])">{{erros['telefones.tel1'].toString()}}</small>
                                </div>
                            </div>
                            <div class="col col-3 col-md-3">
								<div class="form-group">
									<label>Telefone 2</label>
									<input class="form-control form-control-sm" v-model="matricula.telefones.tel2" 
                                            v-mask="['(##) ####-####', '(##) #####-####']" placeholder="Outro telefone (opcional)" type="tel">
                                    <small v-if="erros['telefones.tel2']" class="text-danger" style="font-size:10px" :hidden="(!erros['telefones.tel2'])">{{erros['telefones.tel2'].toString()}}</small>
								</div>
                            </div>
                            <div class="col col-3 col-md-3">
								<div class="form-group">
									<label>Classe da EBD *</label>
									<select class="form-control form-control-sm" v-model="matricula.classe">
                                        <option selected hidden value="">Selecione a Classe da EBD</option>
                                        <option selected :value="'batismo'">Classe de Batismo</option>
                                    </select>
                                    <small class="text-danger" style="font-size:10px" :hidden="(!erros.classe)">{{erros.classe}}</small>
								</div>
							</div>
					    </div>
                        <hr>
                        <div class="row">
                            <div class="col col-6 col-md-6">
								<div class="form-group">
									<label>Logradouro *</label>
									<input class="form-control form-control-sm" placeholder="Insira o Logradouro" type="text"
                                            v-model="matricula.endereco.logradouro" required>
                                    <small v-if="erros['endereco.logradouro']" class="text-danger" style="font-size:10px" :hidden="(!erros['endereco.logradouro'])">{{erros['endereco.logradouro'].toString()}}</small>
								</div>
							</div>
                            <div class="col col-3 col-md-3">
                                <div class="form-group">
									<label>Nº da Casa *</label>
									<input class="form-control form-control-sm" placeholder="Insira o Número da Casa" type="text" v-model="matricula.endereco.num" required>
                                    <small v-if="erros['endereco.num']" class="text-danger" style="font-size:10px" :hidden="(!erros['endereco.num'])">{{erros['endereco.num'].toString()}}</small>
								</div>
							</div>
                            <div class="col col-3 col-md-3">
								<div class="form-group">
									<label>CEP</label>
									<input class="form-control form-control-sm" v-mask="'#####-###'" placeholder="Insira o CEP" type="text" 
                                        v-model="matricula.endereco.cep">
                                    <small v-if="erros['endereco.cep']" class="text-danger" style="font-size:10px" :hidden="(!erros['endereco.cep'])">{{erros['endereco.cep'].toString()}}</small>
								</div>
							</div>
                        </div>
                        <div class="row">
                            <div class="col col-4 col-md-4">
								<div class="form-group">
									<label>Cidade *</label>
									<input class="form-control form-control-sm" placeholder="Insira a Cidade" type="text" v-model="matricula.endereco.cidade" required>
                                    <small v-if="erros['endereco.cidade']" class="text-danger" style="font-size:10px" :hidden="(!erros['endereco.cidade'])">{{erros['endereco.cidade'].toString()}}</small>
								</div>
							</div>
                            <div class="col col-4 col-md-4">
								<div class="form-group">
									<label>Bairro *</label>
									<input class="form-control form-control-sm" placeholder="Insira o Bairro" type="text" v-model="matricula.endereco.bairro" required>
                                    <small v-if="erros['endereco.bairro']" class="text-danger" style="font-size:10px" :hidden="(!erros['endereco.bairro'])">{{erros['endereco.bairro'].toString()}}</small>
								</div>
							</div>
                            <div class="col col-4 col-md-4">
								<div class="form-group">
									<label>Complemento</label>
                                    <textarea class="form form-control" placeholder="Complemento (opcional)" type="text" rows="1" v-model="matricula.endereco.complemento"></textarea>
                                    <small v-if="erros['endereco.complemento']" class="text-danger" style="font-size:10px" :hidden="(!erros['endereco.complemento'])">{{erros['endereco.complemento'].toString()}}</small>
								</div>
							</div>
                        </div>
                    </form>
                    </div>
                    <div class="row">
                        <div class="col col-12 col-md-12">
                            <div style="margin-right:15px;">
                                <p class="small text-danger">* Obrigatório!</p>
                            </div>
                        </div>
                    </div>

					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" :disabled="isRequesting" data-dismiss="modal">Fechar</button> 
						<button type="button" class="btn btn-primary" @click="cadastrar" :disabled="isRequesting==true">
                            {{edicao.id==null||edicao.id==undefined?'Matricular':'Atualizar'}}
                        </button>
					</div>
		    	</div>
		  	</div>
		</div>
    </div>
</template>
<script>
import {TheMask} from 'vue-the-mask'

export default {
    name:'MatriculaPage',

    components:{ TheMask },

    props:{
        edicao:{ type:Object, default:null },
    },

    data() {
        return {
            isRequesting:false, sucesso:false, erros:{},
            matricula:{
                nome:'', sobrenome:'', cpf:'', rg:'', orgao_emissor:'', uf:'', nascimento:'',
                email:'', isEvangelico:false, isMembro:false, classe:'batismo', sexo:false, conversao:'',
                telefones:{tel1:'',tel2:null,}, endereco:{logradouro:'', bairro:'', num:'', cep:'', complemento:'', cidade:''},
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
                {key: "PE", value: "Pernambuco" }, { key: "PI", value: "Piauí" }, { key: "RJ", value: "Rio de Janeiro" },
                {key: "RN", value: "Rio Grande do Norte" }, { key: "RS", value: "Rio Grande do Sul" }, { key: "RO", value: "Rondônia" },
                {key: "RR", value: "Roraima" }, { key: "SC", value: "Santa Catarina" }, { key: "SP", value: "São Paulo" },
                {key: "SE", value: "Sergipe" }, { key: "TO", value: "Tocantins" }
            ]
        }
    },

    watch:{
        ['matricula.endereco.cep'](val,old){
            if(val!='' && val!=old && val!=null && val!=undefined && (val.replace(/\s/g, '').length) && val.indexOf('-')!=-1 && val.length == 9){
                this.getCepInfo();
            }
        },
        edicao(val,old){
            if(val!=null && val!={}){
                this.matricula=Object.assign({},val);
            }
        },
    },

    methods: {
        getCepInfo: _.debounce(function(){
            this.isRequesting=true;
            axios.get('http://viacep.com.br/ws/'+this.matricula.endereco.cep+'/json')
                .then(res=>{
                    this.isRequesting=false; this.erros=[];
                    this.matricula.endereco.logradouro = res.data.logradouro;
                    this.matricula.endereco.complemento = res.data.complemento;
                    this.matricula.endereco.bairro = res.data.bairro;
                    this.matricula.endereco.cidade = res.data.localidade;
                })
                .catch(err=>{ 
                    this.isRequesting=false; console.error(err); 
                    this.erros.endereco.cep=['O CEP informado é inválido!']; 
                })
        },1000),

        cadastrar(){
            if(confirm('Deseja confirmar a matrícula?')){
                this.isRequesting=true;
                axios.post('/atualizar',this.matricula)
                    .then(res=>{
                        this.isRequesting=false; this.sucesso=true; $('.toast').toast('show');
                        alert('Matrícula efetuada com sucesso!!!'); $('#modalMatricula').modal('hide');
                        if(this.edicao!=null){ this.$emit('retornoMatriculas', res.data); }
                    })
                    .catch(err=>{
                        this.isRequesting=false; console.error(err); this.erros=Object.values(err);
                        this.erros = this.erros[2].data; console.log('errrros',this.erros['telefones.tel1']);
                    })
            }
        },

    },
}
</script>