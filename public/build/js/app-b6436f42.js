(function() {
  $('.card').each(function() {
    return $(this).height($(this).width());
  });

  $(window).on('resize', function() {
    return $('.card').each(function() {
      return $(this).height($(this).width());
    });
  });

}).call(this);

(function() {
  var apiURL, contestId, token;

  Array.range = function(a, b, step) {
    var A, s;
    A = [];
    if (typeof a === 'number') {
      A[0] = a;
      step = step || 1;
      while (a + step <= b) {
        A[A.length] = a += step;
      }
    } else {
      s = 'abcdefghijklmnopqrstuvwxyz';
      if (a === a.toUpperCase()) {
        b = b.toUpperCase();
        s = s.toUpperCase();
      }
      s = s.substring(s.indexOf(a), s.indexOf(b) + 1);
      A = s.split('');
    }
    return A;
  };

  if (window.Vue && $('#contest-entries').length) {
    apiURL = $('meta[name="ws::contest.entries"]').attr('content');
    contestId = $('meta[name="ws::contest"]').attr('content');
    token = $('meta[name="csrf_token"]').attr('content');
    window.contest = new Vue({
      el: '#contest-entries',
      data: {
        entries: [],
        currentPage: 1,
        totalPages: 1,
        pages: []
      },
      created: function() {
        return this.fetchData();
      },
      filters: {
        paginate: function() {
          var v;
          v = this;
          return this.entries.filter((function(_this) {
            return function(item) {
              return item.page === v.currentPage;
            };
          })(this));
        }
      },
      computed: {
        pageList: function() {
          var from;
          from = this.currentPage;
          from = Math.min(this.totalPages, this.currentPage + 3) - 3;
          from = Math.max(1, from);
          return Array.range(from, Math.min(this.currentPage + 3, this.totalPages));
        }
      },
      methods: {
        fetchData: function(page) {
          var resource, v;
          v = this;
          if (!page) {
            page = Math.ceil(this.entries.length / 16);
          }
          resource = this.$resource(apiURL);
          return resource.get({
            _token: token,
            page: page
          }, function(data) {
            var entry, i, len, ref, results;
            console.log(data);
            page = data.meta.pagination.current_page;
            v.totalPages = data.meta.pagination.total_pages;
            v.pages.push(page);
            v.pages.sort();
            ref = data.data;
            results = [];
            for (i = 0, len = ref.length; i < len; i++) {
              entry = ref[i];
              entry.page = page;
              results.push(v.entries.push(entry));
            }
            return results;
          });
        },
        goToPage: function(event, page) {
          event.preventDefault();
          if (page === -1) {
            this.currentPage = Math.max(1, this.currentPage - 1);
          } else if (page === 0) {
            this.currentPage = Math.min(this.totalPages, this.currentPage + 1);
          } else {
            this.currentPage = page;
          }
          page = this.currentPage;
          if (this.pages.indexOf(page) === -1) {
            return this.fetchData(page);
          }
        },
        openEntry: function(event) {
          var href, resource;
          event.preventDefault();
          href = $(event.currentTarget).attr('href');
          resource = this.$resource(href);
          return resource.get({}, function(data) {
            var l;
            l = $('<div>').addClass('modal-compare').html(data);
            $('body').append(l);
            return $('#close-comparator').show().click(function(e) {
              e.preventDefault();
              return $(this).parent().parent().remove();
            });
          });
        }
      }
    });
  }

}).call(this);

//# sourceMappingURL=app.js.map