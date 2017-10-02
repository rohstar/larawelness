<template>
    <div class="container">
        <div class="row">
            <div class="panel-body">
                <chartjs-bar v-for="(item, key) in data" :datalabel="key" :labels="Object.keys(item)" :scalesdisplay="false"
                             :data="Object.values(item)"></chartjs-bar>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        data: function () {

            return {
                data: data
            }

        },

        mounted() {
        }
    }
</script>
