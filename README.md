# social-feed-core

A library for loading posts from social networks.

## Architecture

- Core
  - *interface* `INetwork` - Network
  - *class* `AbstractNetwork` - Abstract implementation of `INetwork`
  - *class* `Source` - Abstraction of `INetwork` for accessing to one of sources of network by id
- Utility
  - *trait* `OptionsTrait` - Utility trait for some options containers
  - *class* `RequestOptions` - Options for post requesting
- Cache
  - *interface* `ICache` - Cache. Several containers with cached posts of networks
  - *class* `NetworkCache` - Abstraction of `ICache` for accessing to one of containers by network classname
  - *class* `CacheableNetwork` - Extension of `AbstractNetwork` for cacheable networks
