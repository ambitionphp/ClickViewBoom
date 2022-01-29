<x-app-layout>
    <div>
        <div class="max-w-xl mx-auto py-2 px-6 lg:px-8">

            <h1 class="font-semibold text-xl mb-2">API Overview</h1>

            <ul class="nav nav-pills flex flex-col md:flex-row flex-wrap list-none pl-0 mb-2">
                <li class="nav-item" role="presentation">
                    <a href="{{ route('docs.api') }}" class="
                      nav-link
                      block
                      font-medium
                      text-xs
                      leading-tight
                      uppercase
                      rounded
                      px-6
                      py-3
                      my-2
                      md:mr-2
                      focus:outline-none focus:ring-0
                    ">Overview</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('docs.api.secrets') }}" class="
                      nav-link
                      block
                      font-medium
                      text-xs
                      leading-tight
                      uppercase
                      rounded
                      px-6
                      py-3
                      my-2
                      md:mr-2
                      focus:outline-none focus:ring-0
                    ">Secrets</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ route('docs.api.postman') }}" class="
                      nav-link
                      block
                      font-medium
                      text-xs
                      leading-tight
                      uppercase
                      rounded
                      px-6
                      py-3
                      my-2
                      md:mr-2
                      focus:outline-none focus:ring-0
                      bg-gray-700
                      text-white
                    ">Run in Postman</a>
                </li>
            </ul>

            <div class="mb-4">
                <h3 class="font-semibold text-l mb-2">
                    Run in Postman
                </h3>

                <div class="text-sm mb-3">
                    Fork our Postman collection so you can dive right into our API :)
                </div>

                <div class="postman-run-button"
                     data-postman-action="collection/fork"
                     data-postman-var-1="19373134-0c415253-cac3-4f9d-869c-578cab4722cb"
                     data-postman-collection-url="entityId=19373134-0c415253-cac3-4f9d-869c-578cab4722cb&entityType=collection&workspaceId=3489d3e2-cf9a-43e1-907e-ca9dcc894633"></div>
                <script type="text/javascript">
                    (function (p,o,s,t,m,a,n) {
                        !p[s] && (p[s] = function () { (p[t] || (p[t] = [])).push(arguments); });
                        !o.getElementById(s+t) && o.getElementsByTagName("head")[0].appendChild((
                            (n = o.createElement("script")),
                                (n.id = s+t), (n.async = 1), (n.src = m), n
                        ));
                    }(window, document, "_pm", "PostmanRunObject", "https://run.pstmn.io/button.js"));
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
