# social-feed-core

A library for loading posts from social networks.

## Architecture

- Core
  - *interface* `IPostProvider` - Some provider of posts
  - *class* `OptionsProfile` - Profile with default options for `IPostProvider`
  - *class* `Manager` - Manager for a several `IPostProvider` instances
- Utility
  - *trait* `OptionsTrait` - Utility trait for some options containers
  - *class* `RequestOptions` - Options for post requesting
- Cache
  - *interface* `ICache` - Cache
  - *class* `CachePart` - Part of cache for a `IPostProvider` implementation
- Associating
