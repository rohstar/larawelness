<template>
    <div class="jumbotron">
        <h1>{{ques.question}}</h1>
        <div class="radio">
            <label>
                <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
               {{ques.option_1}}
            </label>
        </div>
        <div class="radio">
            <label>
                <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                {{ques.option_2}}
            </label>
        </div>
        <!--<div class="radio disabled">-->
            <!--<label>-->
                <!--<input type="radio" name="optionsRadios" id="optionsRadios3" value="option3">-->
                <!--{{q.option_3}}-->
            <!--</label>-->
        <!--</div>-->
        <!--<div class="radio disabled">-->
            <!--<label>-->
                <!--<input type="radio" name="optionsRadios" id="optionsRadios3" value="option3">-->
                <!--{{q.option_4}}-->
            <!--</label>-->
        <!--</div>-->
        <p><a class="btn btn-primary btn-lg right" href="#" v-on:click.prevent="submit">Submit!</a></p>
    </div>
</template>

<script>
    export default {
        data(){
            return {

            }
        },
        props:[
            'ques'
        ],
        mounted() {
            console.log(this.ques);
        },
        methods:{

            submit(){
                console.log('answered!');
            }
        }
    }
</script>

<style>

    label{
        font-size: 22px;
    }

    .jumbotron{
        background: darkseagreen;
        color: white;
        width: 92%;
    }



</style>
