if (Vue && $('#contest-entries').length)
    apiURL = $('meta[name="ws::contest.entries"]').attr('content')
    contestId = $('meta[name="ws::contest"]').attr('content')
    token = $('meta[name="csrf_token"]').attr('content')
    window.contest = new Vue({
        el: '#contest-entries'
        data: {
            entries: [],
        },
        created: () ->
            this.fetchData()

        filters: {},
        methods: {
            fetchData: () ->
                v = this
                this.$http.get(apiURL,
                    {_token: token, from: this.entries.length},
                    (data) ->
                        v.entries.push(entry) for entry in data.data
#                        if (data.data.length)
#                            v.fetchData()
                )
        },
    })