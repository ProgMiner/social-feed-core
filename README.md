# social-feed-core

A library for loading posts from social networks.

## Architecture

- Core
  - *interface* `IPostProvider` - Some provider of posts
  - *class* `OptionsProfile` - Profile with default options for `IPostProvider`
  - *class* `Manager` - Manager for a several `IPostProvider` instances
- Utility
  - *trait* `OptionsTrait` - Utility trait for some options containers
  - *abstract class* `AbstractConfigurationOptions` - Options powered by `ConfigurationInterface`
  - *class* `RequestOptions` - Options for post requesting
  - *class* `Post` - Post
  - *class* `IndexedPost` - Post from `IIndexedCache`
- Cache
  - *interface* `ICache` - Cache
  - *interface* `IIndexedCache` - Cache, where every post have unique ID
  - *class* `CachePart` - Part of a cache for a `IPostProvider` implementation
- Associating
