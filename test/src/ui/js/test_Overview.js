module("Overview", {
  'setup': function() {
    BMTestUtils.OverviewPre = BMTestUtils.getAllElements();

    BMTestUtils.setupFakeLogin();

    // Create the overview_page div so functions have something to modify
    if (document.getElementById('overview_page') == null) {
      $('body').append($('<div>', {'id': 'overview_page', }));
    }
  },
  'teardown': function() {

    // Delete all elements we expect this module to create

    // JavaScript variables
    delete Api.active_games;
    delete Api.completed_games;
    delete Overview.page;

    // Page elements
    $('#overview_page').remove();
    $('#overview_page').empty();

    BMTestUtils.deleteEnvMessage();
    BMTestUtils.cleanupFakeLogin();

    // Fail if any other elements were added or removed
    BMTestUtils.OverviewPost = BMTestUtils.getAllElements();
    deepEqual(
      BMTestUtils.OverviewPost, BMTestUtils.OverviewPre,
      "After testing, the page should have no unexpected element changes");
  }
});

// pre-flight test of whether the Overview module has been loaded
test("test_Overview_is_loaded", function() {
  ok(Overview, "The Overview namespace exists");
});

asyncTest("test_Overview.showOverviewPage", function() {
  Overview.showOverviewPage();
  var item = document.getElementById('overview_page');
  equal(item.nodeName, "DIV",
        "#overview_page is a div after showOverviewPage() is called");
  start();
});

asyncTest("test_Overview.getOverview", function() {
  Overview.getOverview(function() {
    ok(Api.active_games, "active games are parsed from server");
    ok(Api.completed_games, "active games are parsed from server");
    start();
  });
});

asyncTest("test_Overview.showPage", function() {
  Overview.getOverview(function() {
    Overview.showPage();
    var htmlout = Overview.page.html();
    ok(htmlout.length > 0,
       "The created page should have nonzero contents");
    start();
  });
});

asyncTest("test_Overview.layoutPage", function() {
  Overview.getOverview(function() {
    Overview.page = $('<div>');
    Overview.page.append($('<p>', {'text': 'hi world', }));
    Overview.layoutPage();
    var item = document.getElementById('overview_page');
    equal(item.nodeName, "DIV",
          "#overview_page is a div after layoutPage() is called");
    start();
  });
});

asyncTest("test_Overview.pageAddGameTables", function() {
  Overview.getOverview(function() {
    Overview.page = $('<div>');
    Overview.pageAddGameTables();
    ok(true, "No special testing of pageAddGameTables() as a whole is done");
    start();
  });
});

asyncTest("test_Overview.pageAddNewgameLink", function() {
  Overview.getOverview(function() {
    Overview.page = $('<div>');
    Overview.pageAddNewgameLink();
    deepEqual(Overview.page.html(),
      "<div><p><a href=\"create_game.html\">Create a new game</a></p></div>",
      "Page link contents are correct");
    start();
  });
});

asyncTest("test_Overview.pageAddGameTable", function() {
  Overview.getOverview(function() {
    Overview.page = $('<div>');
    Overview.pageAddGameTable('awaitingPlayer', 'Waiting for player');
    var htmlout = Overview.page.html();
    ok(htmlout.match('<h2>Waiting for player'), "Section header should be set");
    ok(htmlout.match('<table>'), "A table is created");
    start();
  });
});
