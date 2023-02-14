MastodonPostStatus();

function MastodonPostStatus() {
    console.log(process.env);

    fetch('https://mastodon.social/api/v1/statuses', { 
    method: 'post', 
    headers: new Headers({
        'Authorization': 'Bearer ' + process.env.MASTODON_TEST_ACCESS, 
        'Content-Type': 'application/json'
    }), 
    body: JSON.stringify({"status": "Hello from js"})
    })
    .then(function (response) {
        return response.json();
    })
    .then(function (myJson) {
        console.log(myJson);
    })
    .catch(function (error) {
        console.log("Error: " + error);
    });
}

