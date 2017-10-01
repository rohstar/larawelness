<template>
    <div>
        <div v-if="!answered" class="jumbotron">
            <h1>{{ques.info.question}}</h1>
            <div class="radio">
                <label><input type="radio" name="optionsRadios" value="option_1" v-on:click="select('option_1')"
                              :checked="selected === 'option_1'">{{ques.info.option_1}}</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="optionsRadios" value="option_2" v-on:click="select('option_2')"
                              :checked="selected === 'option_2'">{{ques.info.option_2}}</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="optionsRadios" value="option_3" v-on:click="select('option_3')"
                              :checked="selected === 'option_3'">{{ques.info.option_3}}</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="optionsRadios" value="option_4" v-on:click="select('option_4')"
                              :checked="selected === 'option_4'">{{ques.info.option_4}}</label>
            </div>
        </div>
        <div v-else class="jumbotron">
            <h1>{{ques.info.question}}</h1>
            <p>
                You answered: {{ques.info[selected]}}<br/>
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
            'ques',
            'patientId'
        ],
        created() {

            if (this.ques.answer !== null) {
                this.selected = this.ques.answer;
                this.answered = true;

            }

        },
        methods: {
            select(option) {

                this.selected = option;

                axios.post('/api/record',
                    {

                        'user_id': this.patientId,
                        'question_id': this.ques.info.id,
                        'answer_key': this.selected

                    }).then(function (response) {

                        console.log(response.data);

                    })
                    .catch(response => console.log(response.data));

                this.answered = true;

            },
            undo() {
                this.answered = false
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
