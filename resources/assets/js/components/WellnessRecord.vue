<template>
    <div class="container">
        <div class="row" style="text-align: center">
            <question v-for="q in questions" :key="q.id" :ques="q"></question>
        </div>
    </div>
</template>

<script>

    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    export default {
        data(){
            return {
                questions: [
//                    {
//                        id: 1,
//                        question: 'hello?',
//                        option_1: 1,
//                        option_2: 2,
//
//                    },{
//                        id: 2,
//                        question: 'hello again?',
//                        option_1: 2,
//                        option_2: 3,
//
//                    },
                ]
            }
        },
        props:[
            'patientId'
        ],
        created(){
            console.log(this.patientId);

            this.fetchQuestionsForPatient(this.patientId);
        },
        methods:{

            fetchQuestionsForPatient(id){

                axios.get('/api/user/'+id+'/questions/today')
                    .then(response => console.log(response.data))
                    .catch(response => console.log(response.data));

            }

        }

    }
</script>
