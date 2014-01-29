# MajorApi
MajorApi was a service that made it very easy to connect to QuickBooks. It created a REST API between the QuickBooks WebConnector application and QuickBooks Desktop. Unfortunately, the service failed to take off, so we shut it down after a year of use and open sourced the code.o

The codebase is comprised of two repositories. This repository is the main website and QuickBooks REST API. The [major-api-worker][major-api-worker] repository contains the code that did all of the background data processing through Resque.

## Contact Us
If you are interested in custom QuickBooks development or integration, please get in touch with us at <admin@brightmarch.com>.

## License
The MIT License (MIT)

Copyright (c) 2014 Bright March

[major-api-worker]: https://github.com/brightmarch/major-api-worker
