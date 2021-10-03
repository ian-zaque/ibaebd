<template>
    <div class="container">
        <div class="text-center" style="margin-bottom:8px;">
            <h5 class="card-title" style="font-size:40px;">Igreja Batista Alvorada</h5>
            <p class="card-text" style="font-size:15px;">Feira de Santana - Bahia</p>
        </div>

         <div v-if="showEbdDiscipuladora" class="card text-center" style="border-radius:15px; margin-bottom:8px;">
            <div class="card-body">                
                <p class="card-text " style="font-size:35px;">EBDiscipuladora</p>

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

        <div v-if="showManhaDivertida" class="card text-center" style="border-radius:15px;">
            <div class="card-body">
                <p class="card-text" style="font-size:55px; color:#fc8618; font-family:fantasy;">Manhã Divertida!</p>

                <div class="container">
                    <div class="row">
                        <div class="col-12 ">
                            <div class="d-flex justify-content-between">
                                <p class="bd-lead" style="font-size:30px;">Dia: 16 de Outubro</p>
                                <p class="bd-lead" style="font-size:30px;">Horário: 08:30 às 12:30</p>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top:8px;">
                        <div class="col-12">
                            <p class="d-flex justify-content-center" style="font-size:30px;">Quem pode participar?</p>
                            <small class="d-flex justify-content-center" style="font-size:22px;">Crianças de 3 a 12 anos!</small>
                            <small class="d-flex justify-content-center" style="font-size:15px;">
                                Crianças de 3 a 5 anos acompanhados por responsáveis!!!
                            </small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <img src="imagens/logo_iba.png" style="margin-bottom:15px;" width="120px" height="170px" class="img-fluid float-center">
                        </div>
                    </div>
                </div>
                
                <div class="d-grid gap-2">
                    <button class="btn btn-primary btn-block" id="btn_manha" type="button" @click="abrirModalManhaDivertida()"
                        style="font-size:35px; background-color:#fc8618; color:#18468d; font-family:fantasy;">
                        Inscrição aqui!
                    </button>
                </div>
            </div>
        </div>

        <!--  MODAL MATRICULA EBD DISCIPULADORA -->
        <matricula-page :isEditing="isEditing"></matricula-page>
        <matricula-manhaDivertida :isEditingManha="isEditingManha"></matricula-manhaDivertida>
    </div>
</template>
<script>
import {TheMask} from 'vue-the-mask'

export default {
    name:'HomePage',

    components:{ TheMask },

    data() {
        return {
            erros:{}, isEditing:null, isEditingManha:null,
            matricula:{
                nome:'', sobrenome:'', nascimento:'',
                // cpf:'', rg:'', orgao_emissor:'', uf:'',
                email:'', classe:'batismo', isEvangelico:0, sexo:0, conversao:'', membresia:'',
                telefones:{tel1:'',tel2:null,}, endereco:{logradouro:'', bairro:'', num:'', cep:'', complemento:'', cidade:''},
            },

            showManhaDivertida:true, showEbdDiscipuladora:false,
        }
    },

    methods: {
        abrirModalMatricula(){
            this.erros={}; this.isEditing=false;
            if(this.matricula!=null && this.matricula.hasOwnProperty('id')){ delete this.matricula.id; }
            this.matricula={
                nome:'', sobrenome:'', nascimento:'',
                // cpf:'', rg:'', orgao_emissor:'', uf:'',
                email:'', classe:'batismo', isEvangelico:0, sexo:0, conversao:'', membresia:'',
                telefones:{tel1:'',tel2:null,}, endereco:{logradouro:'', bairro:'', num:'', cep:'', complemento:'', cidade:''},
            };
            $('#modalMatricula').modal('show');
        },

        abrirModalManhaDivertida(){
            this.erros={}; this.isEditingManha= false;
            $('#modalManhaDivertida').modal('show');
        },
    },

}
</script>
