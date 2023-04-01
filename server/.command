### create new field

curl --request POST --url "https://api.trello.com/1/lists?name=NewBoard&idBoard=6426d95f6befeddebaa0932e&key=67bc04932cd3151dd2c9c9f6f68dbf0e&token=ATTA99b957d975035e6d3fe5026d2e09f659696ff5dfe30fa2a1a70086ad9c4b8e4750CB4918"

###

curl --request POST \
  --url "https://api.trello.com/1/webhooks/?callbackURL=https://128c-109-227-121-144.eu.ngrok.io/trello&idModel=6426d95f6befeddebaa0932e&key=67bc04932cd3151dd2c9c9f6f68dbf0e&token=ATTA99b957d975035e6d3fe5026d2e09f659696ff5dfe30fa2a1a70086ad9c4b8e4750CB4918" \
  --header "Accept: application/json"
