from requests_html import HTMLSession
from bs4 import BeautifulSoup
print('doing')
tokens = [
            'yflr-yfin',
            'xusd-yflr',
            'fltc-yflr',
            'fdoge-yflr',
            'yfin-xusd',
            'fltc-yfin',
            'fdoge-yfin',
            'yflr-fxrp',
            'fxrp-yfin',
            'xusd-fxrp',
            'fltc-fxrp',
            'fdoge-fxrp',
            'xusd-fltc',
            'fdoge-fltc',
            'fdoge-xusd'
        ]

# tokens = tokens.reverse()

for token in tokens:
    print('Processing: ' + token)
    session = HTMLSession()
    resp = session.get("https://flaremetrics.io/scrape/snapshot" + token)
    resp.html.render(sleep=1, keep_page=True, timeout=36.0)
#     # print('Loaded ' + token ' chart')
print('done')
exit()

