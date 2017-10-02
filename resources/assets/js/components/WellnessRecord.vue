<template>
    <div class="container">
        <div class="row">
            <question v-for="q in questions" :key="q.id" :record="q" :patient-id="patientId"></question>
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
                axios.get('/api/user/' + id + '/today')
                    .then(function (response) {

                        vm.questions = response.data
                    })
                    .catch(response => console.log(response.data));

            }

        }

    }
</script>
