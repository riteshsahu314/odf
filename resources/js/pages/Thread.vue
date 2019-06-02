<script>
    import Replies from '../components/Replies.vue';
    import SubscribeButton from '../components/SubscribeButton.vue';

    export default {
        components: { Replies, SubscribeButton },

        props: ['thread'],

        data() {
            return {
                repliesCount: this.thread.replies_count,
                title: this.thread.title,
                body: this.thread.body,
                form: {},
                editing: false,
                locked: this.thread.locked
            }
        },

        created() {
            this.resetForm();
        },

        methods: {
            update() {
                let uri = `/threads/${this.thread.channel.slug}/${this.thread.slug}`;

                axios.patch(uri, this.form)
                    .then(() => {
                        this.editing = false;

                        this.title = this.form.title;
                        this.body = this.form.body;

                        flash('Your thread has been updated.');
                    })
            },

            resetForm() {
                this.form = {
                    title: this.thread.title,
                    body: this.thread.body
                };

                this.editing = false;
            },

            toggleLock() {
                axios[this.locked ? 'delete' : 'post']('/locked-threads/' + this.thread.slug);

                this.locked = ! this.locked;
            }
        }
    }
</script>
