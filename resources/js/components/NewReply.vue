<template>
    <div>
        <div v-if="signedIn">
            <div class="form-group">
<!--                                <textarea class="form-control"-->
<!--                                          name="body" id="body"-->
<!--                                          placeholder="Have something to say?"-->
<!--                                          rows="5" v-model="body" required>-->
<!--                                </textarea>-->
                <wysiwyg-editor name="body" v-model="body" placeholder="Reply to the thread" :shouldClear="completed"></wysiwyg-editor>
            </div>

            <button type="submit" class="btn btn-primary" @click="addReply">Post</button>
        </div>

        <p class="text-center" v-else>
            Please <a href="/login">sign in</a> to participate in this
            discussion
        </p>
    </div>
</template>

<script>
    export default {
        name: "NewReply",

        data() {
            return {
                body: '',
                completed: false
            };
        },
        //
        // computed: {
        //     signedIn() {
        //         return window.App.signedIn;
        //     }
        // },

        methods: {
            addReply() {
                // axios.post(this.endpoint, { body: this.body })
                //     .then(response => {
                //         this.body = '';
                //
                //         flash('Your reply has been posted.');
                //
                //         this.$emit('created', response.data);
                //     });

                axios.post(location.pathname + '/replies', { body: this.body })
                    .catch(error => {
                        flash(error.response.data, 'danger');
                    })
                    .then(({data}) => {
                        this.body = '';
                        this.completed = true;

                        flash('Your reply has been posted.');

                        this.$emit('created', data);
                    });
            }
        }
    }
</script>

<style scoped>

</style>
