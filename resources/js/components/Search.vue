<template>
    <ais-instant-search :search-client="searchClient" index-name="threads" class="row">
        <div class="col-md-4">
            <ais-configure :query="query"/>

            <div class="card mb-2">
                <div class="card-header">
                    Search
                </div>
                <div class="card-body">
                    <ais-search-box placeholder="Find a thread..." :autofocus="true" />
                </div>
                <img src="https://odf-bucket.s3.ap-south-1.amazonaws.com/images/algolia.svg" alt="algolia logo" class="w-75 mx-auto pb-3">
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
                    'DOZ621768P',
                    '4af27885f4ad89fa8ac81452a8fda9f8'
                ),
            };
        },
    };
</script>
