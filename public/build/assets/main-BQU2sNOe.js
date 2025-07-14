document.addEventListener("DOMContentLoaded",d=>{document.querySelectorAll("form").forEach(o=>{o.addEventListener("submit",function(a){a.preventDefault();const i=a.target,t=i.querySelector(".btn-submit"),e=i.querySelector(".btn-cancel");if(t){const r=t.offsetWidth;t.style.width=`${r}px`,t.setAttribute("disabled",!0),t.innerHTML=`
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                `}return e&&(e.classList.add("disabled"),e.setAttribute("disabled",!0)),this.submit()})});const s=$(".flash-data").data("flash"),n=$(".flash-data-failed").data("flash");s&&new Swal({title:"Success",html:s,icon:"success",confirmButtonText:"OK",customClass:{popup:"rounded-4",confirmButton:"px-4 bg-primary rounded-3"}}),n&&new Swal({title:"Oops!",html:n,icon:"error",confirmButtonText:"OK",customClass:{popup:"rounded-4",confirmButton:"px-4 bg-primary rounded-3"}})});
