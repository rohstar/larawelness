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
            'patientId',
            'record'
        ],
        created() {
            this.fetchQuestionsForRecord(this.patientId, this.record.id);
        },
        methods: {

            fetchQuestionsForRecord(id, recordId) {

                let utc = new Date().toJSON().slice(0,10).replace(/-/g,'-');
                let vm = this;

                axios.get('/api/user/' + id + '/wellness-record/' + recordId + '/' + utc)
                    .then(function (response) {

                        vm.questions = response.data
                    })
                    .catch(response => console.log(response.data));

            }

        }

    }
</script>
