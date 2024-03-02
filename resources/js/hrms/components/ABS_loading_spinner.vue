<template>
        <div  class="modal-mask" >
          <div class="modal-wrapper">
            <div class="modal-container red" :breakpoints="{ '960px': '75vw', '640px': '90vw' }"  :style="{ width: '35vw', height: '40vh' }">

              <div class="modal-body" style="margin: auto;">
                <ProgressSpinner
                style="width: 80px; height: 80px ;margin-left: 170px;margin-top: 20px;"
                strokeWidth="6"
                fill="var(--surface-ground)"
                animationDuration="5s"
                aria-label="Custom ProgressSpinner"
              />
              </div>

              <div class="modal-footer" style="margin: auto; display: flex; justify-content: center;align-items: center; margin-top: 120px;">
                <h5 >Please wait...</h5>
              </div>
            </div>
          </div>
        </div>
</template>

<style>
.red{
    background: linear-gradient(rgba(255, 255, 255, 0.867), rgba(255, 255, 255, 0.812)), url(./logo.jpg) no-repeat;
    background-attachment: local;
    background-size: contain;
    background-position-y: center;
    margin: auto;
    padding: 30px;

}

.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: table;
    transition: opacity 0.3s ease;
  }

  .modal-wrapper {
    display: table-cell;
    vertical-align: middle;
  }

  .modal-container {
    width: 300px;
    margin: 0px auto;
    padding: 20px 30px;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
    transition: all 0.3s ease;
  }

  .modal-header h3 {
    margin-top: 0;
    color: #42b983;
  }

  .modal-body {
    margin: 20px 0;
  }

  .modal-default-button {
    float: right;
  }

  /*
   * The following styles are auto-applied to elements with
   * transition="modal" when their visibility is toggled
   * by Vue.js.
   *
   * You can easily play with the modal transition by editing
   * these styles.
   */

  .modal-enter-from {
    opacity: 0;
  }

  .modal-leave-to {
    opacity: 0;
  }

  .modal-enter-from .modal-container,
  .modal-leave-to .modal-container {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
  }

</style>
