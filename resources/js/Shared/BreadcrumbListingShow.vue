<template>
    <div>
        <div class="uk-width-expand">
            <ol vocab="https://schema.org/" typeof="BreadcrumbList" class="uk-grid-small uk-grid uk-grid-divider uk-padding-small uk-flex-nowrap uk-overflow-auto uk-text-nowrap" uk-grid>
                <li property="itemListElement" typeof="ListItem">
                    <Link property="item" typeof="WebPage" class="uk-text-danger darker uk-padding-small uk-padding-remove-horizontal" :href="route('home')">
                        <span property="name">Početna</span>
                    </Link>
                    <meta property="position" content="1">
                </li>

                <li property="itemListElement" typeof="ListItem">
                    <Link property="item" typeof="WebPage" class="uk-text-danger darker uk-padding-small uk-padding-remove-horizontal" :href="route('listing.index')">
                        <span property="name">Izdavanje</span>
                    </Link>
                    <meta property="position" content="2">
                </li>

                <li property="itemListElement" typeof="ListItem">
                    <Link property="item" typeof="WebPage" class="uk-text-danger darker uk-padding-small uk-padding-remove-horizontal" :href="route('listing.index', { district: l.district })">
                        <span property="name">{{ l.district }}</span>
                    </Link>
                    <meta property="position" content="3">
                </li>

                <li property="itemListElement" typeof="ListItem">
                    <Link property="item" typeof="WebPage" class="uk-text-danger darker uk-padding-small uk-padding-remove-horizontal" :href="route('listing.index', { county: l.county })">
                        <span property="name">{{ l.county }}</span>
                    </Link>
                    <meta property="position" content="4">
                </li>

                <li property="itemListElement" typeof="ListItem">
                    <Link property="item" typeof="WebPage" class="uk-text-danger darker uk-padding-small uk-padding-remove-horizontal" :href="route('listing.index', { city: l.city })">
                        <span property="name">{{ l.city }}</span>
                    </Link>
                    <meta property="position" content="5">
                </li>

                <li property="itemListElement" typeof="ListItem">
                    <Link property="item" typeof="WebPage" class="uk-text-danger darker uk-padding-small uk-padding-remove-horizontal" :href="route('listing.index', { type: l.type_human, city: l.city })">
                        <span property="name">{{ l.type_human }}</span>
                    </Link>
                    <meta property="position" content="6">
                </li>
            </ol>
        </div>
        <div class="uk-width-auto uk-padding-small uk-visible@m" v-if=" ! $page.props.user">
            Niste Ulogovani. <Link :href="route('login')">Prijavi se / Registruj</Link>
        </div>
    </div>
</template>

<script setup>
    defineProps({
        l: Object
    });
</script>
