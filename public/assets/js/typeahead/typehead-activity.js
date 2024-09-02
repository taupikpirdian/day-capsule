(function ($) {
    var substringMatcher = function (strs) {
      return function findMatches(q, cb) {
        var matches, substringRegex;
        matches = [];
        substrRegex = new RegExp(q, "i");
        $.each(strs, function (i, str) {
          if (substrRegex.test(str)) {
            matches.push(str);
          }
        });
        cb(matches);
      };
    };

    var url = "activity/titles";
    callDataWithAjax(url, 'POST', "").then((data) => {
        var states = data;
        var states = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: states,
        });
        $("#bloodhound .typeahead").typeahead(
            {
            hint: true,
            highlight: true,
            minLength: 1,
            },
            {
            name: "states",
            source: states,
            }
        );
    }).catch((xhr) => {
        alert('Error: ' + xhr.responseText);
    })
  })(jQuery);
  