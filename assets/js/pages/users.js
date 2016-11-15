/**
 * Page-specific Javascript file.  Should generally be included as a separate asset bundle in your page template.
 * example: {{ assets.js('js/pages/sign-in-or-register') | raw }}
 *
 * This script depends on uf-table.js, moment.js, handlebars-helpers.js
 *
 * Target page: /users
 */

$(document).ready(function() {
    
    $("#widget-users").ufTable({
        dataUrl: site.uri.public + "/api/users",
        addParams: {
            "group": "users"
        },
        DEBUG: false
    });
    
    $("#widget-users").on("pagerComplete.ufTable", function () {
        console.log("Done paging!");
        // Link row buttons
        //bindUserTableButtons($('#' + table_id));
    });
});
