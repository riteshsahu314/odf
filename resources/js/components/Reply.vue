<template>
    <div :id="'reply-' + id" class="card my-4">
        <div class="card-header">
            <div class="level">
                <h5 class="flex">
                    <a :href="'/profiles/' + data.owner.name"
                       v-text="data.owner.name">
                    </a> said <span v-text="ago"></span>
                </h5>

                <div v-if="signedIn">
                    <favorite :reply="data"></favorite>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div v-if="editing">
                <form @submit="update">
                    <div class="form-group">
                        <wysiwyg-editor v-model="body"></wysiwyg-editor>
<!--                        <textarea v-model="body" class="form-control" required></textarea>-->
                    </div>

                    <button class="btn btn-sm btn-primary">Update</button>
                    <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
                </form>
            </div>
            <div v-else v-html="body"></div>
        </div>

        <!--        @can ('update', $reply)-->
        <div class="card-footer level" v-if="authorize('owns', reply)">
            <button class="btn btn-secondary btn-sm mr-2" @click="editing = true">Edit</button>
            <button class="btn btn-danger btn-sm mr-2" @click="destroy" type="submit">Delete</button>
        </div>
        <!--        @endcan-->
    </div>
</template>

<script>
    import Favorite from './Favorite.vue';
    import moment from 'moment';

    export default {
        name: "Reply.vue",
        props: ['data'],

        // child components
        components: {Favorite},

        data() {
            return {
                editing: false,
                id: this.data.id,
                body: this.data.body,
                reply: this.data
            };
        },

        computed: {
            ago() {
                return moment(this.data.created_at).fromNow() + '...';
            }

            // signedIn() {
            //     return window.App.signedIn;
            // }

            // canUpdate() {
            //     return this.authorize(user => this.data.user_id == user.id);
            //     // return this.data.user_id == window.App.user.id;
            // }
        },

        methods: {
            update() {
                axios.patch(
                    '/replies/' + this.data.id, {
                    body: this.body
                })
                .then(() => {
                    flash('Updated!');
                })
                .catch(error => {
                    flash(error.response.data, 'danger');
                });

                this.editing = false;
            },

            destroy() {
                axios.delete('/replies/' + this.data.id);

                // grab the root element and fade it out using jQuery
                // $(this.$el).fadeOut(300, () => {
                //     flash('Your reply has been deleted.');
                // });

                this.$emit('deleted', this.data.id);

            }
        }
    }
</script>

<style>

</style>
