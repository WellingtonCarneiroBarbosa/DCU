<template>
     <div class="col-md-6 mt-4">
        <div class="card card-default">
            <div class="card-header">Cadastar Demanda</div>

            <div class="card-body">
                <form action="#" method="GET" @submit.prevent="addDemand()">

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="demand" class="col-form-label">Nome da Demanda</label>

                            <input class="form-control" type="text" v-model="name">
                        </div>

                        <div class="col-md-6">
                            <label for="priority" class="col-form-label">Prioridade</label>

                            <select class="form-control" v-model="priority">
                                <option value="1">Baixa</option>
                                <option value="2">Média</option>
                                <option value="3">Alta</option>
                                <option value="4">Urgente</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label for="description" class="col-form-label">Descrição</label>

                            <textarea class="form-control" v-model="description" cols="30" rows="10"></textarea>
                        </div>

                        <div class="col-md-12 mt-2">
                            <div class="float-right">
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data () {
        return {
            name: '',
            priority: '',
            description: '',
        }
    },

    mounted () {
        console.log("Demand-Create Component mounted successfully");
    },

    methods: {

        validateData () {
            if(this.name == '' || this.priority == '' || this.description == '') {
                alert('Preencha todos os campos!');
            }
            return;
        },

        appended () {
            console.log('appended!');
        },

        addDemand () {
            this.validateData();

            alert('Adding Demand');
            axios.post('/api/public/demands', {
                token: process.env.MIX_API_SUPPORT_KEY,
                demand: this.name, 
                priority: this.priority, 
                description: this.description
            })
            .then(function (response) {
                if(response.data.code == 500) {
                    alert('erro ao salvar demanda');
                }
                console.log(response);
            })
            .catch(function (error) {
                console.log(error);
            });
        }
    }
}
</script>