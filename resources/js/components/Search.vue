<template>
    <ais-instant-search :search-client="searchClient" index-name="threads" class="row">
        <div class="col-md-4">
            <ais-configure :query="query"/>

            <div class="card">
                <div class="card-header">
                    Search
                </div>
                <div class="card-body">
                    <ais-search-box placeholder="Find a thread..." :autofocus="true" />
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Filter By Channel
                </div>
                <div class="card-body">
                    <ais-refinement-list attribute="channel.name"/>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <ais-hits>
                <ul slot-scope="{ items }">
                    <li v-for="item in items">
                        <a :href="item.path">
                            <ais-highlight attribute="title" :hit="item"/>
                        </a>
                    </li>
                </ul>
            </ais-hits>
        </div>
    </ais-instant-search>
</template>

<script>
    import algoliasearch from 'algoliasearch/lite';
    import 'instantsearch.css/themes/algolia-min.css';

    export default {
        props: ['query'],

        data() {
            return {
                searchClient: algoliasearch(
                    'MH3XVJMFES',
                    '3ed3dddbaa73857e0a8cb5c2500d537e'
                ),
            };
        },
    };
</script>
