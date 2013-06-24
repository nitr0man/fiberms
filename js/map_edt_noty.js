function showInformation( layout, message ) {
    if ( typeof notyInformation !== "undefined" ) {
        notyInformation.close();
    }
    notyInformation = noty( {
        text: message,
        type: 'information',
        dismissQueue: true,
        layout: layout,
        theme: 'defaultTheme'
    } );
}

function showDeleteCableLineQuestion( layout, message, yesFunc ) {
    notyQuestion = noty( {
        text: message,
        type: 'alert',
        dismissQueue: true,
        layout: layout,
        theme: 'defaultTheme',
        buttons: [
            { addClass: 'btn btn-primary', text: 'Да', onClick: function(
                        $noty ) {
                    $noty.close();
                    yesFunc();
                }
            },
            { addClass: 'btn btn-danger', text: 'Нет', onClick: function(
                        $noty ) {
                    $noty.close();
                }
            }
        ]
    } );
}

function showError( layout, message ) {
    if ( typeof notyError !== "undefined" ) {
        notyError.close();
    }
    notyError = noty( {
        text: message,
        type: 'error',
        dismissQueue: true,
        layout: layout,
        theme: 'defaultTheme'
    } );
    setTimeout( function() {
        notyError.close();
    }, 4000 );
}