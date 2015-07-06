(function() {
  var apiURL, contestId, token;

  if (window.Vue && $('#contest-entries').length) {
    apiURL = $('meta[name="ws::contest.entries"]').attr('content');
    contestId = $('meta[name="ws::contest"]').attr('content');
    token = $('meta[name="csrf_token"]').attr('content');
    window.contest = new Vue({
      el: '#contest-entries',
      data: {
        entries: []
      },
      created: function() {
        return this.fetchData();
      },
      filters: {},
      methods: {
        fetchData: function() {
          var v;
          v = this;
          return this.$http.get(apiURL, {
            _token: token,
            from: this.entries.length
          }, function(data) {
            var entry, i, len, ref, results;
            ref = data.data;
            results = [];
            for (i = 0, len = ref.length; i < len; i++) {
              entry = ref[i];
              results.push(v.entries.push(entry));
            }
            return results;
          });
        }
      }
    });
  }

}).call(this);

//# sourceMappingURL=app.js.map