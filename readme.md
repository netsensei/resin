## Resin App

Resin for your [Resolver](https://github.com/PACKED-vzw/resolver). This application will take your bare data and generate
a nice, valid import CSV file for the resolver application. Additionally, the
app will report if your list of URL's and objects match, how many items will
be or won't be merged, and what you could do about it.

# Features

* Merges documents and objects into a CSV import file.
* Detect orphan documents and objects (unmergeable)
* Sets representation URL if the copyright of the artist is not cleared.

# Import schemata

Resin has 3 major entity types: object, document and artist. Each of which has a
set of properties. Ingestion of data happens via CSV import. Your import files
should adhere to these schema's:

Object:

* object_number
* title
* work_pid
* artist_id

Document:

* object_number
* URL
* data
* representation_1
* representation_2
* representation_X

Artist:

* artist_id
* name
* PID
* year_birth
* year_death
* copyright

### License

Resin is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
