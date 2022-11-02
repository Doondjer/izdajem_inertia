export default  {
    methods: {
        route(name, params = {}) {
            if(laravel && laravel.health) {
                const route = _.find(laravel.health.routes.list, (route) => {
                    return route.name === name
                })

                let routeUri = route.uri

                Object.entries(params).forEach(([key, value]) => {
                    routeUri = routeUri.replace('{'+key+'}', value)
                })

                return routeUri
            }

        },
    },
}
