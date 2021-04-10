<template>
    <div class="container">
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

        <!--  MODAL -->
        <matricula-page></matricula-page>

        <!-- <div class="position-fixed bottom-0 right-0 p-3" style="z-index: 5; right: 0; bottom: 0;"> -->
            <!-- <div v-if="sucesso==true" style="position: absolute; bottom: 0; left: 0;" class="toast hide" data-autohide="false" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <img src="imagens/logo_iba.png" class="rounded mr-2" alt="...">
                    <strong class="mr-auto">Sucesso!!!</strong>
                    <button type="button" @click="sucesso=false" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body">
                    Matrícula efetuada com sucesso. <hr>
                    Em breve entraremos em contato!
                </div>
            </div> -->
        <!-- </div> -->
    </div>
</template>
<script>
import {TheMask} from 'vue-the-mask'

export default {
    name:'HomePage',

    components:{ TheMask },

    data() {
        return {
        }
    },

    methods: {
        abrirModalMatricula(){
            this.erros=[];
            this.matricula={
                nome:'', sobrenome:'', cpf:'', rg:'', orgao_emissor:'', uf:'', nascimento:'',
                email:'', isEvangelico:0, isMembro:0, classe:'batismo', sexo:0, conversao:'',
                telefones:{tel1:'',tel2:null,}, endereco:{logradouro:'', bairro:'', num:'', cep:'', complemento:'', cidade:'',},
            };
            $('#modalMatricula').modal('show');
        },
    },

}
</script>
