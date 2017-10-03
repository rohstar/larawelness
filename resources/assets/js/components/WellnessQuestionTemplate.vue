<template>
    <div>
        <div v-if="!answered" class="jumbotron">
            <h1>{{record.question}}</h1>
            <div class="radio">
                <label><input type="radio" name="question_radio" value="option_1" v-on:click="select('option_1')"
                              :checked="selected === 'option_1'">{{record.option_1}}</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="question_radio" value="option_2" v-on:click="select('option_2')"
                              :checked="selected === 'option_2'">{{record.option_2}}</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="question_radio" value="option_3" v-on:click="select('option_3')"
                              :checked="selected === 'option_3'">{{record.option_3}}</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="question_radio" value="option_4" v-on:click="select('option_4')"
                              :checked="selected === 'option_4'">{{record.option_4}}</label>
            </div>
        </div>
        <div v-else class="jumbotron">
            <h1>{{record.question}}</h1>
            <p>You answered: {{record[selected]}}<br/>
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
                answer: ''
            }
        },
        props: [
            'record',
            'userRecord',
            'patientId'
        ],
        created() {

            if (this.record.answer !== null) {
                this.selected = this.record.answer;
                this.answered = true;

            }

        },
        methods: {
            select(option) {

                this.selected = option;

                axios.post('/api/user/' + this.patientId + '/wellness-record',
                    {

                        'user_id': this.patientId,
                        'question_id': this.record.id,
                        'answer_key': this.selected

                    }).then(function (response) {

                    })
                    .catch(response => console.log(response.data));

                this.answered = true;

            },

            undo() {

                axios.delete('/api/user/' + this.patientId + '/wellness-record/' + this.userRecord + '/question/' + this.record.id,
                    {

                        'user_id': this.patientId,
                        'question_id': this.record.id,
                        'answer_key': this.selected

                    }).then(function (response) {

                })
                    .catch(response => console.log(response.data));

                this.answered = false;
                this.selected = '';

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
