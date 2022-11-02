import {reactive} from "vue";
import { client } from "./Client";

export const addressAutocomplete =  _.throttle(() => {

return reactive({
    data: {},
    processing: false,
    url: 'https://autocomplete.search.hereapi.com/v1/autocomplete',
    errors: {},
    hasErrors: false,
    hasData: false,
    min_q: 4,
    params: {
        q: '',
        lang: 'sr-Latn-CS',
        apiKey: import.meta.env.VITE_HERE_API_KEY,
        in: 'countryCode:SRB',
    },
    setError(key, value) {
        Object.assign(this.errors, (value ? { [key]: value } : key))

        this.hasErrors = Object.keys(this.errors).length > 0

        return this
    },
    clearErrors(...fields) {

        this.errors = Object
            .keys(this.errors)
            .reduce((carry, field) => ({
                ...carry,
                ...(fields.length > 0 && !fields.includes(field) ? { [field] : this.errors[field] } : {}),
            }), {})

        this.hasErrors = Object.keys(this.errors).length > 0

        return this
    },
    clearData() {

        this.data = {}

        this.hasData = false

        return this
    },
    search(q) {
        let that=this;

        if (q.length < that.min_q) {
            return;
        }

        client.interceptors.request.use(function (config) {

            that.processing = true;
            return config;
        }, function (error) {
            return Promise.reject(error);
        }, { synchronous: true });

        client.interceptors.response.use(function (response) {
            // Any status code that lie within the range of 2xx cause this function to trigger
            that.processing = false

            return response;
        }, function (error) {
            // Any status codes that falls outside the range of 2xx cause this function to trigger
            that.processing = false;
            // Something happened in setting up the request that triggered an Error
            that.clearErrors().setError('search', 'Ouups, došlo je do greške, pokušajte kasnije ponovo!');
            return Promise.reject(error);
        });

        this.params.q = q;

        client.get(this.url, {
            params: this.params,
            transformRequest: (data, headers) => {
                delete headers.common['X-Requested-With'];
                return data;
            }
        }).then(({data}) =>  {
            Object.assign(this.data, data.items);
            this.hasData = Object.keys(this.data).length > 0
        }).catch(e => console.dir(e));
    },
})
},500);

export const getFromId = () => {
    return reactive({
        processing: false,
        errors: {},
        data: {},
        clearError() {
          this.errors = {};
        },
        clearData() {
          this.data = {};
        },
        fetch(id) {
            this.processing = true;
            client.get(`https://lookup.search.hereapi.com/v1/lookup`, {
                params: {
                    id: id,
                    apiKey: import.meta.env.VITE_HERE_API_KEY,
                    jsonattributes: 1,
                    gen: 9,
                    lang: 'sr-Latn-CS',
                },
                transformRequest: (data, headers) => {
                    delete headers.common['X-Requested-With'];
                    return data;
                }
            }).then(({data}) => {
                Object.assign(this.data, data);
                this.processing = false;
            }).catch(e => {
                    Object.assign(this.errors, {'target': 'Ouups, došlo je do greške, pokušajte kasnije ponovo!'});
                    this.processing = false;
                    console.dir(e);
                });
        }
    })
}
