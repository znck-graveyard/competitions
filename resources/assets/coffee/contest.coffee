Array.range = (a, b, step)->
    A = []
    if(typeof a == 'number')
        A[0] = a
        step = step || 1;
        while(a + step <= b)
            A[A.length] = a += step
    else
        s = 'abcdefghijklmnopqrstuvwxyz';
        if(a is a.toUpperCase())
            b = b.toUpperCase()
            s = s.toUpperCase()
        s = s.substring(s.indexOf(a), s.indexOf(b) + 1)
        A = s.split('')
    A

if (window.Vue && $('#contest-entries').length)
    apiURL = $('meta[name="ws::contest.entries"]').attr('content')
    contestId = $('meta[name="ws::contest"]').attr('content')
    token = $('meta[name="csrf_token"]').attr('content')
    window.contest = new Vue({
        el: '#contest-entries'
        data: {
            entries: [],
            currentPage: 1,
            totalPages: 1,
            pages: [],
        },
        created: () ->
            this.fetchData()

        filters: {
            paginate: () ->
                v = this
                this.entries.filter((item) => item.page == v.currentPage)
        },
        computed: {
            pageList: () ->
                from = this.currentPage
                from = Math.min(this.totalPages, this.currentPage + 3) - 3
                from = Math.max(1, from)
                Array.range(from, Math.min(this.currentPage + 3, this.totalPages))
        },
        methods: {
            fetchData: (page) ->
                v = this
                if(!page)
                    page = Math.ceil(this.entries.length / 16)

                resource = this.$resource(apiURL)
                resource.get(
                    {_token: token, page: page},
                    (data) ->
                        console.log(data)
                        page = data.meta.pagination.current_page
                        v.totalPages = data.meta.pagination.total_pages
                        v.pages.push(page)
                        v.pages.sort()
                        for entry in data.data
                            entry.page = page
                            v.entries.push(entry)
                )
            goToPage: (event, page) ->
                event.preventDefault()
                if (page == -1)
                    this.currentPage = Math.max(1, this.currentPage - 1)
                else if(page == 0)
                    this.currentPage = Math.min(this.totalPages, this.currentPage + 1)
                else
                    this.currentPage = page

                page = this.currentPage
                if this.pages.indexOf(page) == -1
                    this.fetchData(page)
        },
    })