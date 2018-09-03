# social-feed-core

A library for loading posts from social networks.

## Architecture

- *class* `Author` - Post author
- *interface* `Cache` - Cache
  - *interface* `Indexed` - Cache, where every post have unique ID
- *class* `CachePart` - Part of a cache, associated with one source
- Exception
  - *class* `API` - API exception
- *class* `Hub` - Hub of post providers
- Impl
  - VK
    - *class* `PostProvider` - VK.com post provider
    - *class* `Exception` - VK.com API exception
- *abstract class* `Post` - Post
  - *abstract class* `Cached` - Cached post
  - *abstract class* `Indexed` - Cached and indexed post
- *interface* `PostProvider` - Post provider
- *abstract class* `Request` - Posts request
