import fs from "fs"

const jsonObject = JSON.parse(fs.readFileSync('./version.json', 'utf8'));
console.log(jsonObject[0]["version"])

node -p -e 'const version=require("./version.json");`RELEASED_VERSION=v${version[version.length - 1]["version"]}`'
