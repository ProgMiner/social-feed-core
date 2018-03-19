# social-feed-core

A library for loading posts from social networks.

## Architecture

- Core
  - `INetwork` - Network
  - `Source` - Abstraction of `INetwork` for accessing to one of sources of network by id
  - Utility
    - `OptionsTrait` - Utility trait for some options containers
    - `RequestOptions` - Options for post requesting
- Cache
  - `ICache` - Cache. Several containers with cached posts of networks
  - `NetworkCache` - Abstraction of `ICache` for accessing to one of containers by network classname
