<template>
    <div class="container">
        <div class="row">
            <question v-for="(item, index) in questions" :key="index" :ques="item" :patient-id="patientId"></question>
        </div>
    </div>
</template>

<script>

    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    export default {
        data() {
            return {
                questions: []
            }
        },
        props: [
            'patientId'
        ],
        created() {
            this.fetchQuestionsForPatient(this.patientId);
        },
        methods: {

            fetchQuestionsForPatient(id) {

                let vm = this;
                axios.get('/api/user/' + id + '/questions/today')
                    .then(function (response) {

                        vm.questions = response.data
                    })
                    .catch(response => console.log(response.data));

            }

        }

    }
</script>
