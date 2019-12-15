AOL-TAC
=======

[![Project Status: Unsupported – The project has reached a stable, usable state but the author(s) have ceased all work on it. A new maintainer may be desired.](https://www.repostatus.org/badges/latest/unsupported.svg)](https://www.repostatus.org/#unsupported)

TAC is an implementation of TOC2.0 for AOL Instant Messaging.

TOC2.0 Login Description
----------------

Primary Method (Secure?):

    toc2_login <auth_serv> <auth_port> <username> <password> <language> <client version> <country?> <country> <hash?> 3 0 03 0303 -kentucky -utf8 <hash>

---

Another method (less secure?):

    toc2_signon <auth_serv> <auth_port> <username> <password> <language> <client> <hash>

---


*<hash>* denotes a numerical hash of the username/password (need an algorithm for this)
