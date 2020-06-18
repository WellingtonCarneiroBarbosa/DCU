<template>
    <div class="col-md-6 mt-4">
        <div class="card card-default">
            <div class="card-header">Lista de Demandas</div>

            <div class="card-body">
                <div class="demands" v-for="demand in demands" :key="demand.id">
                    id = <span>{{ demand.id }}</span>
                    <br>
                    nome = <span>{{ demand.demand }}</span>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            demands: []
        }
    },

    mounted () {
        console.log('Demands-List Component Mounted')
    },

    created () {
        axios.get('/api/public/demands', {
            params: {
                token: process.env.MIX_API_SUPPORT_KEY
            }
        })
    
        .then(response => this.demands = response.data.data)
    }
}
</script>