$( e.target ).pagecontainer( "load", redirect, {
    type: "get",
    reload: true,
    deferred: triggerData.options.deferred,
    fromPage: triggerData.options.fromPage
} );
e.preventDefault();
