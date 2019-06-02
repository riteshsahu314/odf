<template>
    <button type="submit" :class="classes" @click="toggle">
        <span class="oi oi-heart"></span>
        <span v-text="count"></span>
    </button>
</template>

<script>
    export default {
        name: "Favorite.vue",
        props: ['reply'],

        data() {
            return {
                count: this.reply.favoritesCount,
                active: this.reply.isFavorited
            }
        },

        computed: {
            classes() {
                return ['btn', this.active ? 'btn-primary' : 'btn-secondary'];
            },

            endpoint() {
                return '/replies/' + this.reply.id + '/favorites';
            }
        },

        methods: {
            toggle() {
                this.active ? this.destroy() : this.create();
            },

            create() {
                // favorite the reply
                axios.post(this.endpoint);

                this.active = true;

                this.count++;
            },

            destroy() {
                // unfavorite the reply
                axios.delete(this.endpoint);

                this.active = false;

                this.count--;
            }
        }
    }
</script>
