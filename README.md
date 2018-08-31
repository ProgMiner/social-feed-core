# social-feed-core

A library for loading posts from social networks.

## Architecture

- Core
  - *interface* `IPostProvider` - Post provider
  - *class* `Hub` - Hub of post providers
  - *class* `Request` - Posts request
  - *class* `Post` - Post
  - *class* `IndexedPost` - Post from `IIndexedCache`
- Cache
  - *interface* `ICache` - Cache
  - *interface* `IIndexedCache` - Cache, where every post have unique ID
  - *class* `CachePart` - Part of a cache for a `IPostProvider` implementation
- Associating
- Impl
