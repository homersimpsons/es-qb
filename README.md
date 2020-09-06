# EsQb

An Elasticsearch Query Builder.

You should choose EsQb if you need the following requirements:
- **Strong typing**: Ensure your code will work thanks to static analysis
- **Fearless upgrades**: Upgrading to a future Elasticsearch version will just require a `composer update`

# Contributing

## How to contribute

The current goal is to map every query to specific classes.

When adding a query you need to add its unit test(s) and integration test.

## Tests

### Unit tests

Unit tests do not need any connection, they are located under `tests/Unit` directory.

To run this tests please use `composer test`.

### Integration tests

Integration tests do need an active Elasticsearch instance, they are located under `tests/Integration` directory.

You can create an instance with the following [docker](https://www.docker.com/) command:

```shell script
docker run -d --name elasticsearch -p 9200:9200 -e "discovery.type=single-node" elasticsearch:7.8.0
```

Once the instance is running you can run the tests against it with `composer test:integration`

# Inspiration

As a base inspiration there is [The official Elasticsearch query builder](https://github.com/elastic/elasticsearch/tree/master/server/src/main/java/org/elasticsearch/index/query).
