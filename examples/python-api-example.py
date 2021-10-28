import requests

api_key = ""

headers = {"X-API-KEY": api_key}

root_url = "https://api.flaremetrics.io"
auth_url = "/v1/auth"
provider_url = "/v1/ftso/provider/"
providers_url = "/v1/ftso/providers"

# Make Request (Auth)
request = requests.get(root_url + auth_url, headers=headers)

# Make Request (Provider)
provider_id = "0x4990320858ae3528b645c60059281a66c3488888" # UID (6399723), Code (FTSOAU) [if exists] or pool address [if exists]
# request = requests.get(root_url + provider_url + provider_id, params = {'fields': 'all'}, headers=headers)

# Make Request (Providers)
# request = requests.get(root_url + providers_url, params = {'fields': 'all'}, headers=headers)

# Make Request (Providers Paginated)
# request = requests.get(root_url + providers_url, params = {'fields': 'all', 'paginate': 'true', 'perPage': 2, 'currentPage': 1}, headers=headers)

# Print Status Code & Output
print(request.status_code, request.json())