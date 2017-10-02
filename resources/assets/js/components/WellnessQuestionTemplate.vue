<template>
    <div>
        <div v-if="!answered" class="jumbotron">
            <h1>{{record.question}}</h1>
            <div class="radio">
                <label><input type="radio" name="optionsRadios" value="option_1" v-on:click="select('option_1')"
                              :checked="selected === 'option_1'">{{record.option_1}}</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="optionsRadios" value="option_2" v-on:click="select('option_2')"
                              :checked="selected === 'option_2'">{{record.option_2}}</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="optionsRadios" value="option_3" v-on:click="select('option_3')"
                              :checked="selected === 'option_3'">{{record.option_3}}</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="optionsRadios" value="option_4" v-on:click="select('option_4')"
                              :checked="selected === 'option_4'">{{record.option_4}}</label>
            </div>
        </div>
        <div v-else class="jumbotron">
            <h1>{{record.question}}</h1>
            <p>
                You answered: {{record[selected]}}<br/>
                <chartjs-horizontal-bar :datalabel="'Past 7 Days'" :labels="answer_keys" :data="record.history"></chartjs-horizontal-bar>
                <button class="btn btn-default" v-on:click.prevent="undo">Undo</button>
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                selected: '',
                answered: false,
                answer: '',
                answers: [],
                answer_keys: [],
            }
        },
        props: [
            'record',
            'patientId'
        ],
        mounted() {

            this.updateHistory();

        },
        created() {

            if (this.record.answer !== null) {
                this.selected = this.record.answer;
                this.answered = true;

                this.answer_keys =
                    [
                        this.record.option_1,
                        this.record.option_2,
                        this.record.option_3,
                        this.record.option_4
                    ]

            }

        },
        methods: {
            select(option) {

                this.selected = option;

                axios.post('/api/record',
                    {

                        'user_id': this.patientId,
                        'question_id': this.record.id,
                        'answer_key': this.selected

                    }).then(function (response) {
                    }).catch(response => console.log(response.data));

                this.answered = true;
                this.updateHistory();

            },

            undo() {

                this.answered = false;
                this.selected = '';
                this.updateHistory();



            },

            updateHistory(){

                let _vm = this;

                axios.get('/api/user/' + this.patientId + '/history/' + this.record.id).
                then(function (response) {

                    _vm.answers = response.data;

                }).catch(response => console.log(response.data));

            }
        }
    }
</script>

<style scoped>

    label {
        font-size: 22px;
    }

    .jumbotron {
        background: darkseagreen;
        color: white;
        width: 92%;
    }

    h1 {
        font-size: 30px;
    }


</style>
