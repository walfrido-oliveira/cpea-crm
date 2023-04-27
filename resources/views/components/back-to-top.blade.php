
<div id="back2Top" class="hidden bg-gray-100 rounded-lg text-center float-right cursor-pointer p-2 fixed right-5 bottom-5">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
    </svg>
</div>

<script>
{
    const back2Top = document.querySelector('#back2Top');
    const element = document.getElementById("{{ $attributes['element'] }}").scrollTop;

    function scrollFunction() {
        if (document.body.scrollTop > element || document.documentElement.scrollTop > element) {
            back2Top.style.display = "block";
        } else {
            back2Top.style.display = "none";
        }
    }

    window.onscroll = function() {scrollFunction()};

    back2Top.addEventListener('click', (e) => {
        e.preventDefault();
        window.scroll({ top:0, left:0, behavior: 'smooth'});
    });
}
</script>
